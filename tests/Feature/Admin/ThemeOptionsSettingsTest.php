<?php

use App\Http\Controllers\Pages\Admin\Settings\ThemeOptions;
use App\Models\Setting;
use App\Models\User;
use Tests\Support\PageTest;

it('authorized users can access theme options page', function () {
    $superAdmin = User::factory()->superAdmin()->create();

    $this->actingAs($superAdmin)
        ->get(route('admin.theme-options'))
        ->assertOk();
});

it('stores typography settings as separate keys with autoload flag', function () {
    $superAdmin = User::factory()->superAdmin()->create();

    PageTest::actingAs($superAdmin)
        ->test(ThemeOptions::class)
        ->set('primary_font', 'Poppins')
        ->set('primary_font_weights', '300;400;500;600;700')
        ->set('body_font_size', '16px')
        ->set('autoload', true)
        ->call('saveTypography')
        ->assertHasNoErrors();

    $primaryFont = Setting::query()->where('group', 'typography')->where('key', 'primary_font')->first();
    $fontWeights = Setting::query()->where('group', 'typography')->where('key', 'primary_font_weights')->first();
    $bodyFontSize = Setting::query()->where('group', 'typography')->where('key', 'body_font_size')->first();

    expect($primaryFont?->value)->toBe('Poppins');
    expect($fontWeights?->value)->toBe('300;400;500;600;700');
    expect($bodyFontSize?->value)->toBe('16px');
    expect($primaryFont?->autoload)->toBeTrue();
});
