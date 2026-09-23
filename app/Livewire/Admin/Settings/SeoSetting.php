<?php

namespace App\Livewire\Admin\Settings;

use App\Support\SettingsStore;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithFileUploads;

class SeoSetting extends Component
{
    use WithFileUploads;

    public $meta_title;

    public $meta_description;

    public $meta_keywords;

    public $og_image;

    public $existing_og_image;

    public $twitter_handle;

    public function mount()
    {
        $settings = SettingsStore::group('seo');

        $this->meta_title = $settings['meta_title'] ?? config('app.name');
        $this->meta_description = $settings['meta_description'] ?? '';
        $this->meta_keywords = $settings['meta_keywords'] ?? '';
        $this->existing_og_image = $settings['og_image'] ?? '';
        $this->twitter_handle = $settings['twitter_handle'] ?? '@qerobi';
    }

    public function save()
    {
        $this->validate([
            'meta_title' => 'required|string|max:100',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'twitter_handle' => 'nullable|string|max:50',
            'og_image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'twitter_handle' => $this->twitter_handle,
            'og_image' => $this->existing_og_image,
        ];

        if ($this->og_image) {
            $path = $this->og_image->store('settings/seo', 'public');
            $data['og_image'] = $path;
            $this->existing_og_image = $path;
        }

        SettingsStore::saveGroup('seo', $data);

        Flux::toast('SEO Settings updated successfully!', 'Success');
    }

    public function render()
    {
        return view('livewire.admin.settings.seo-setting')
            ->layout('layouts.app', ['title' => 'SEO Settings']);
    }
}
