<?php

namespace App\Http\Controllers\Pages\SuperAdmin\Settings;

use App\Http\Controllers\PageController;
use App\Http\Controllers\Concerns\InteractsWithPagination;
use App\Http\Controllers\Pages\Traits\InteractsWithToasts;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Schema;

class ActivityLogs extends PageController
{
    use InteractsWithToasts, InteractsWithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function clearLogs()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);

        if (Schema::hasTable('activity_logs')) {
            ActivityLog::truncate();
            $this->toastSuccess('সবগুলো অ্যাক্টিভিটি লগ সফলভাবে মুছে ফেলা হয়েছে!');
            $this->resetPage();

            // Log this specific action too
            log_activity('cleared_logs', 'Cleared all activity logs');
        }
    }

    public function render()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);

        $logs = collect();
        if (Schema::hasTable('activity_logs')) {
            $logs = ActivityLog::with('user')
                ->when($this->search !== '', function ($query) {
                    $query->where('action', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhere('ip_address', 'like', '%'.$this->search.'%')
                        ->orWhereHas('user', function ($q) {
                            $q->where('name', 'like', '%'.$this->search.'%')
                                ->orWhere('email', 'like', '%'.$this->search.'%');
                        });
                })
                ->latest()
                ->paginate(15);
        }

        return view('pages.superadmin.settings.activity-logs', [
            'logs' => $logs,
        ])->layout('layouts.app', ['title' => 'Activity Logs']);
    }
}
