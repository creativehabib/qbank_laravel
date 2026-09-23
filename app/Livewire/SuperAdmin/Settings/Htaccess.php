<?php

namespace App\Livewire\SuperAdmin\Settings;

use Flux\Flux;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class Htaccess extends Component
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
            Flux::toast('Root .htaccess saved successfully!', 'Success');
        } else {
            $path = public_path('.htaccess');
            File::put($path, $this->publicContent);
            Flux::toast('Public .htaccess saved successfully!', 'Success');
        }
    }

    public function render()
    {
        return view('livewire.superadmin.settings.htaccess')
            ->layout('layouts.app', ['title' => '.htaccess Editor']);
    }
}
