<?php

namespace App\Http\Controllers\Pages\Admin\Settings;

use App\Http\Controllers\PageController;

class Languages extends PageController
{
    public $perPage = 10;

    public function render()
    {
        return view('pages.admin.settings.languages')->layout('layouts.app', ['title' => 'Languages']);
    }
}
