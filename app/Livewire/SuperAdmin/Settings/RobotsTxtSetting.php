<?php

namespace App\Livewire\SuperAdmin\Settings;

use Flux\Flux;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class RobotsTxtSetting extends Component
{
    public $content = '';

    public function mount()
    {
        $path = public_path('robots.txt');
        if (File::exists($path) && !empty(trim(File::get($path)))) {
            $this->content = File::get($path);
        } else {
            $this->content = "User-agent: *\nDisallow:\n\nSitemap: ".url('sitemap.xml');
        }
    }

    public function save()
    {
        $this->validate([
            'content' => 'required|string',
        ]);

        $path = public_path('robots.txt');
        File::put($path, $this->content);

        Flux::toast('robots.txt saved successfully!', 'Success');
    }

    public function render()
    {
        return view('livewire.superadmin.settings.robots-txt-setting')
            ->layout('layouts.app', ['title' => 'Robots.txt Setting']);
    }
}
