<?php

namespace App\Http\Controllers\Pages\SuperAdmin\Settings;

use App\Http\Controllers\PageController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SitemapSetting extends PageController
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

        $this->toast('Sitemap generated successfully!', 'success', 'Success');
    }

    public function render()
    {
        return view('pages.superadmin.settings.sitemap-setting')
            ->layout('layouts.app', ['title' => 'Sitemap Setting']);
    }
}
