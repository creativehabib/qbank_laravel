<?php

namespace App\Livewire\SuperAdmin\Settings;

use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class SitemapSetting extends Component
{
    public $sitemapExists = false;

    public $lastModified = null;

    public $fileSize = null;

    public $isGenerating = false;

    public function mount()
    {
        $this->checkSitemap();
    }

    public function checkSitemap()
    {
        $path = public_path('sitemap.xml');
        if (File::exists($path)) {
            $this->sitemapExists = true;
            $this->lastModified = Carbon::createFromTimestamp(File::lastModified($path))->diffForHumans();
            $this->fileSize = round(File::size($path) / 1024, 2).' KB';
        } else {
            $this->sitemapExists = false;
            $this->lastModified = null;
            $this->fileSize = null;
        }
    }

    public function generateSitemap()
    {
        $this->isGenerating = true;

        // Call the artisan command directly to reuse the logic
        Artisan::call('sitemap:generate');

        $this->checkSitemap();
        $this->isGenerating = false;

        Flux::toast('Sitemap generated successfully!', 'Success');
    }

    public function render()
    {
        return view('livewire.superadmin.settings.sitemap-setting')
            ->layout('layouts.app', ['title' => 'Sitemap Setting']);
    }
}
