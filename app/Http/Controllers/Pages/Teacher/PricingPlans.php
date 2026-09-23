<?php

namespace App\Http\Controllers\Pages\Teacher;

use App\Http\Controllers\PageController;
use App\Models\Package;
use Illuminate\Contracts\View\View;

class PricingPlans extends PageController
{
    public $perPage = 10;

    public function render(): View
    {
        return view('pages.teacher.pricing-plans', [
            'plans' => Package::query()->where('is_active', true)->orderBy('price')->get(),
        ]);
    }
}
