<?php

namespace App\Http\Controllers\Pages\Admin\ModelTests;

use App\Http\Controllers\PageController;
use App\Http\Controllers\Concerns\InteractsWithPagination;
use App\Models\ModelTest;

class ModelTestIndex extends PageController
{
    use InteractsWithPagination;

    public function delete(ModelTest $modelTest)
    {
        $modelTest->delete();
        session()->flash('success', 'মডেল টেস্ট মুছে ফেলা হয়েছে।');
    }

    public function render()
    {
        return view('pages.admin.model-tests.model-test-index', [
            'modelTests' => ModelTest::withCount('questions')->latest()->paginate(20),
        ])->layout('layouts.app', ['title' => 'Model Tests']);
    }
}
