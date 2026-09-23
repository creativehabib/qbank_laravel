<?php

use App\Http\Controllers\Pages\Admin\PackageManagement;
use App\Models\Package;
use App\Models\User;
use Tests\Support\PageTest;

it('admin can create update and delete package', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(['super_admin']);

    $this->actingAs($admin);

    PageTest::test(PackageManagement::class)
        ->set('name', 'Custom Plan')
        ->set('price', '4500')
        ->set('questionCreateLimit', '4000')
        ->set('pageViewLimit', '0')
        ->set('validityDays', '45')
        ->set('isAdFree', true)
        ->set('isActive', true)
        ->call('save')
        ->assertHasNoErrors();

    $package = Package::query()->where('name', 'Custom Plan')->firstOrFail();

    PageTest::test(PackageManagement::class)
        ->call('edit', $package->id)
        ->set('price', '5000')
        ->call('save')
        ->assertHasNoErrors();

    expect((float) $package->fresh()->price)->toBe(5000.0);

    PageTest::test(PackageManagement::class)
        ->call('delete', $package->id);

    expect(Package::query()->whereKey($package->id)->exists())->toBeFalse();
});

it('package management uses UI controls', function () {
    $view = file_get_contents(base_path('resources/views/pages/admin/package-management.blade.php'));

    expect($view)
        ->toContain('<x-ui.field')
        ->toContain('<x-ui.input')
        ->toContain('<x-ui.checkbox')
        ->toContain('<x-ui.button');
});

it('sends toast notifications for package mutations', function () {
    $source = file_get_contents(base_path('app/Http/Controllers/Pages/Admin/PackageManagement.php'));

    expect($source)
        ->toContain('use InteractsWithToasts;')
        ->toContain("toastSuccess('Package saved successfully.')")
        ->toContain("toastSuccess('Package deleted successfully.')");
});

test('the application uses a shared delete confirmation dialog', function () {
    $dialog = file_get_contents(base_path('resources/views/components/delete-confirmation.blade.php'));
    $helper = file_get_contents(base_path('resources/js/app.js'));

    expect($dialog)
        ->toContain('<x-ui.modal name="delete-confirmation"')
        ->toContain('<x-ui.button variant="danger"')
        ->and($helper)
        ->toContain("window.AppUI?.modal('delete-confirmation').show()")
        ->toContain('window.confirmPendingDeletion');
});
