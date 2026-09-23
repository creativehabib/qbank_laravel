<?php

use App\Http\Controllers\Pages\Teacher\OrganizationInfo;
use App\Models\User;
use Tests\Support\PageTest;

it('teacher can update organization info from dashboard menu page', function () {
    $teacher = User::factory()->teacher()->create([
        'organization_name' => 'Old School',
        'organization_type' => 'School',
        'organization_address' => 'Old address',
    ]);

    $this->actingAs($teacher);

    PageTest::test(OrganizationInfo::class)
        ->set('organizationName', 'Dhaka College')
        ->set('organizationType', 'College')
        ->set('organizationAddress', 'Dhaka, Bangladesh')
        ->call('save')
        ->assertHasNoErrors();

    $teacher->refresh();

    expect($teacher->organization_name)->toBe('Dhaka College')
        ->and($teacher->organization_type)->toBe('College')
        ->and($teacher->organization_address)->toBe('Dhaka, Bangladesh');
});
