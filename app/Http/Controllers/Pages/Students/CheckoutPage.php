<?php

namespace App\Http\Controllers\Pages\Students;

use App\Http\Controllers\PageController;
use App\Http\Controllers\Pages\Traits\InteractsWithToasts;
use App\Models\Package;

class CheckoutPage extends PageController
{
    use InteractsWithToasts;

    public Package $package;

    public function mount($package_id)
    {
        $this->package = Package::findOrFail($package_id);
    }

    public function render()
    {
        return view('pages.students.checkout-page')->layout('layouts.app', ['title' => 'Checkout']);
    }
}
