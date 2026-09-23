<?php

namespace App\Http\Controllers\Pages\Teacher;

use App\Http\Controllers\PageController;
use Illuminate\Contracts\View\View;

class OrganizationInfo extends PageController
{
    public $perPage = 10;

    public string $organizationName = '';

    public string $organizationType = '';

    public string $organizationAddress = '';

    public function mount(): void
    {
        abort_unless(auth()->user()?->isTeacher(), 403);

        $this->organizationName = (string) auth()->user()->organization_name;
        $this->organizationType = (string) auth()->user()->organization_type;
        $this->organizationAddress = (string) auth()->user()->organization_address;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'organizationName' => ['required', 'string', 'max:255'],
            'organizationType' => ['required', 'string', 'max:255'],
            'organizationAddress' => ['required', 'string', 'max:1000'],
        ]);

        auth()->user()->update([
            'organization_name' => $validated['organizationName'],
            'organization_type' => $validated['organizationType'],
            'organization_address' => $validated['organizationAddress'],
        ]);

        session()->flash('success', 'প্রতিষ্ঠানের তথ্য সফলভাবে আপডেট হয়েছে।');
    }

    public function render(): View
    {
        return view('pages.teacher.organization-info');
    }
}
