<?php

namespace App\Http\Controllers\Pages\Students;

use App\Http\Controllers\PageController;
use App\Models\Package;

class PricingPage extends PageController
{
    public function render()
    {
        $subscriptions = Package::where('type', 'subscription')->where('is_active', true)->get();
        $courses = Package::where('type', 'course')->where('is_active', true)->get();

        return view('pages.students.pricing-page', [
            'subscriptions' => $subscriptions,
            'courses' => $courses,
        ])->layout('layouts.app', ['title' => 'Premium Plans & Courses']);
    }
}
