<?php

namespace App\Http\Controllers\Pages\SuperAdmin\Settings;

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\File;

class RobotsTxtSetting extends PageController
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

        $this->toast('robots.txt saved successfully!', 'success', 'Success');
    }

    public function render()
    {
        return view('pages.superadmin.settings.robots-txt-setting')
            ->layout('layouts.app', ['title' => 'Robots.txt Setting']);
    }
}
