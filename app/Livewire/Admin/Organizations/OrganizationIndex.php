<?php

namespace App\Livewire\Admin\Organizations;

use App\Models\Organization;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class OrganizationIndex extends Component
{
    use WithFileUploads, WithPagination;

    public $name = '';

    public $slug = '';

    public $description = '';

    public $official_website = '';

    public $established_year = '';

    public $logo_path = null;

    public $editingId = null;

    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'official_website' => 'nullable|url|max:255',
        'logo_path' => 'nullable|string',
    ];

    public function create()
    {
        $this->reset(['name', 'slug', 'description', 'official_website', 'established_year', 'logo_path', 'editingId']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $organization = Organization::findOrFail($id);
        $this->editingId = $organization->id;
        $this->name = $organization->name;
        $this->slug = $organization->slug;
        $this->description = $organization->description;
        $this->official_website = $organization->official_website;
        $this->logo_path = $organization->logo_path;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'official_website' => $this->official_website,
            'established_year' => $this->established_year,
            'logo_path' => $this->logo_path,
        ];

        if ($this->editingId) {
            Organization::findOrFail($this->editingId)->update($data);
        } else {
            Organization::create($data);
        }

        $this->showModal = false;
        $this->reset(['name', 'slug', 'description', 'official_website', 'established_year', 'logo_path', 'editingId']);
    }

    public function delete($id)
    {
        Organization::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.organizations.organization-index', [
            'organizations' => Organization::latest()->paginate(10),
        ])->layout('layouts.app', ['title' => 'Organizations']);
    }
}
