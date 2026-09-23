<?php

namespace App\Http\Controllers\Pages\Teacher;

use App\Http\Controllers\PageController;
use App\Models\QuestionSet;
use Illuminate\Contracts\View\View;

class MyQuestionSets extends PageController
{
    public $perPage = 10;

    public function render(): View
    {
        $questionSets = QuestionSet::query()
            ->where('user_id', auth()->id())
            ->withCount('questions')
            ->with(['questions:id,question_type'])
            ->latest()
            ->get();

        return view('pages.teacher.my-question-sets', [
            'questionSets' => $questionSets,
        ])->layout('layouts.app');
    }
}
