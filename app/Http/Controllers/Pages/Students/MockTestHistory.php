<?php

namespace App\Http\Controllers\Pages\Students;

use App\Http\Controllers\PageController;
use App\Http\Controllers\Concerns\InteractsWithPagination;
use App\Models\MockTest;

class MockTestHistory extends PageController
{
    public $perPage = 10;

    use InteractsWithPagination;

    public function mount()
    {
        abort_unless(auth()->user()?->isStudent() || auth()->user()?->isJobSeeker(), 403);
    }

    public function render()
    {
        $histories = MockTest::query()
            ->where('user_id', auth()->id())
            ->with(['academicClass:id,name', 'subject:id,name'])
            ->latest()
            ->paginate($this->perPage);

        return view('pages.students.mock-test-history', [
            'histories' => $histories,
        ])->layout('layouts.app', ['title' => 'পরীক্ষার ইতিহাস']);
    }
}
