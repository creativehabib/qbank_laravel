<?php

namespace App\Http\Controllers\Pages\Teacher;

use App\Http\Controllers\PageController;
use App\Models\UserSubscription;
use Illuminate\Contracts\View\View;

class SubscriptionOverview extends PageController
{
    public $perPage = 10;

    public function render(): View
    {
        $subscription = UserSubscription::query()
            ->with('package')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest('id')
            ->first();

        return view('pages.teacher.subscription-overview', [
            'subscription' => $subscription,
        ]);
    }
}
