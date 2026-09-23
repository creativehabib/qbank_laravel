<?php

use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::middleware('auth')->group(function (): void {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', [SettingsController::class, 'profile'])->name('profile.edit');
    Route::patch('settings/profile', [SettingsController::class, 'updateProfile'])->name('profile.update');
    Route::delete('settings/profile', [SettingsController::class, 'destroyProfile'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('settings/appearance', [SettingsController::class, 'appearance'])->name('appearance.edit');
    Route::get('settings/security', [SettingsController::class, 'security'])
        ->middleware(when(
            Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
            ['password.confirm'],
            [],
        ))
        ->name('security.edit');
    Route::put('settings/security/password', [SettingsController::class, 'updatePassword'])->name('security.password.update');
});
