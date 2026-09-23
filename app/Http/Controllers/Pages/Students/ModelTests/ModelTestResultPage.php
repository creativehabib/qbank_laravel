<?php

namespace App\Http\Controllers\Pages\Students\ModelTests;

use App\Http\Controllers\PageController;
use App\Models\ModelTestResult;

class ModelTestResultPage extends PageController
{
    public ModelTestResult $result;

    public function mount($resultId)
    {
        $this->result = ModelTestResult::with('modelTest')->where('id', $resultId)->where('user_id', auth()->id())->firstOrFail();
    }

    public function render()
    {
        return view('pages.students.model-tests.model-test-result-page')
            ->layout('layouts.app', ['title' => 'Exam Result']);
    }
}
