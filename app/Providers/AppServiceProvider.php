<?php

namespace App\Providers;

use App\Support\SettingsStore;
use App\Support\ThemeTypography;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Support/helpers.php');

        // Dynamically update Fortify config before any provider boots
        $this->app->booting(function () {
            try {
                if (Schema::hasTable('settings')) {
                    // Use DB facade directly to avoid Eloquent boot sequence issues
                    // Or safely try to read from Cache first
                    $settings = Cache::get('settings_group_general');

                    if (! $settings) {
                        try {
                            // If not in cache, fetch using DB query builder (safe during booting)
                            $rawSettings = DB::table('settings')
                                ->where('group', 'general')
                                ->get(['key', 'value', 'type']);

                            $settings = [];
                            foreach ($rawSettings as $setting) {
                                $val = $setting->value;
                                if ($setting->type === 'boolean') {
                                    $val = filter_var($val, FILTER_VALIDATE_BOOLEAN);
                                }
                                $settings[$setting->key] = $val;
                            }
                        } catch (\Exception $e) {
                            $settings = [];
                        }
                    }

                    $features = config('fortify.features', []);

                    $userRegistration = $settings['user_registration'] ?? true;
                    $emailVerification = $settings['email_verification'] ?? false;

                    $userRegistration = $settings['user_registration'] ?? true;
                    $emailVerification = $settings['email_verification'] ?? false;

                    if (! $userRegistration) {
                        $features = array_diff($features, ['registration']);
                    } else {
                        if (! in_array('registration', $features)) {
                            $features[] = 'registration';
                        }
                    }

                    if (! $emailVerification) {
                        $features = array_diff($features, ['email-verification']);
                    } else {
                        if (! in_array('email-verification', $features)) {
                            $features[] = 'email-verification';
                        }
                    }

                    config(['fortify.features' => array_values($features)]);
                }
            } catch (\Exception $e) {
                // Ignore during setup/migrations
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->shareThemeTypography();
        $this->configureDynamicSettings();
        $this->registerActivityLogListeners();
    }

    /**
     * Register listeners for automatic activity logging
     */
    protected function registerActivityLogListeners(): void
    {
        Event::listen(Login::class, function ($event) {
            log_activity('login', 'User logged into the system', $event->user->id);
        });

        Event::listen(Logout::class, function ($event) {
            if ($event->user) {
                log_activity('logout', 'User logged out of the system', $event->user->id);
            }
        });

        Event::listen(Registered::class, function ($event) {
            log_activity('registered', 'New user registered', $event->user->id);
        });

        Event::listen(PasswordReset::class, function ($event) {
            log_activity('password_reset', 'User reset their password', $event->user->id);
        });
    }

    /**
     * Override config with values from the database settings
     */
    protected function configureDynamicSettings(): void
    {
        try {
            if (Schema::hasTable('settings')) {
                $mailSettings = SettingsStore::group('mail');
                if (! empty($mailSettings['mail_mailer'])) {
                    config([
                        'mail.default' => $mailSettings['mail_mailer'],
                        'mail.mailers.smtp.host' => $mailSettings['mail_host'] ?? config('mail.mailers.smtp.host'),
                        'mail.mailers.smtp.port' => $mailSettings['mail_port'] ?? config('mail.mailers.smtp.port'),
                        'mail.mailers.smtp.username' => $mailSettings['mail_username'] ?? config('mail.mailers.smtp.username'),
                        'mail.mailers.smtp.password' => $mailSettings['mail_password'] ?? config('mail.mailers.smtp.password'),
                        'mail.mailers.smtp.encryption' => $mailSettings['mail_encryption'] ?? config('mail.mailers.smtp.encryption'),
                        'mail.from.address' => $mailSettings['mail_from_address'] ?? config('mail.from.address'),
                        'mail.from.name' => $mailSettings['mail_from_name'] ?? config('mail.from.name'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Ignore during setup/migrations
        }
    }

    /**
     * Share theme typography settings with every view.
     */
    protected function shareThemeTypography(): void
    {
        View::share('themeTypography', ThemeTypography::current());
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
