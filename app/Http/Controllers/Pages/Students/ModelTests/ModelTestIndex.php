<?php

namespace App\Http\Controllers\Pages\Students\ModelTests;

use App\Http\Controllers\PageController;
use App\Http\Controllers\Concerns\InteractsWithPagination;
use App\Models\ModelTest;

class ModelTestIndex extends PageController
{
    use InteractsWithPagination;

    public function render()
    {
        return view('pages.students.model-tests.model-test-index', [
            'modelTests' => ModelTest::with(['package'])
                ->withCount('questions')
                ->where('is_published', true)
                ->latest()
                ->paginate(15),
        ])->layout('layouts.app', ['title' => 'Available Model Tests']);
    }
}
