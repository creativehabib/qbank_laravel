<?php

namespace App\Http\Controllers\Pages\SuperAdmin\Settings;

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\File;

class Htaccess extends PageController
{
    public $activeTab = 'root';

    public $rootContent = '';

    public $publicContent = '';

    public function mount()
    {
        $this->loadFiles();
    }

    public function loadFiles()
    {
        // Load Root .htaccess
        $rootPath = base_path('.htaccess');
        if (File::exists($rootPath)) {
            $this->rootContent = File::get($rootPath);
        } else {
            $this->rootContent = '';
        }

        // Load Public .htaccess
        $publicPath = public_path('.htaccess');
        if (File::exists($publicPath)) {
            $this->publicContent = File::get($publicPath);
        } else {
            $this->publicContent = '';
        }
    }

    public function save()
    {
        if ($this->activeTab === 'root') {
            $path = base_path('.htaccess');
            File::put($path, $this->rootContent);
            $this->toast('Root .htaccess saved successfully!', 'success', 'Success');
        } else {
            $path = public_path('.htaccess');
            File::put($path, $this->publicContent);
            $this->toast('Public .htaccess saved successfully!', 'success', 'Success');
        }
    }

    public function render()
    {
        return view('pages.superadmin.settings.htaccess')
            ->layout('layouts.app', ['title' => '.htaccess Editor']);
    }
}
