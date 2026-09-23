<?php

namespace App\Http\Controllers\Pages\Admin\Settings;

use App\Http\Controllers\PageController;

class Index extends PageController
{
    public $perPage = 10;

    public function render()
    {
        return view('pages.admin.settings.index')->layout('layouts.app', ['title' => 'Settings']);
    }
}
