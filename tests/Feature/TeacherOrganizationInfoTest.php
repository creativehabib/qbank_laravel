<?php

use App\Livewire\Teacher\OrganizationInfo;
use App\Models\User;
use Livewire\Livewire;

it('teacher can update organization info from dashboard menu page', function () {
    $teacher = User::factory()->teacher()->create([
        'organization_name' => 'Old School',
        'organization_type' => 'School',
        'organization_address' => 'Old address',
    ]);

    $this->actingAs($teacher);

    Livewire::test(OrganizationInfo::class)
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
