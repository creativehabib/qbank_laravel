<?php

namespace App\Http\Controllers\Pages\Frontend;

use App\Http\Controllers\PageController;
use App\Models\Question;

class GlobalSearch extends PageController
{
    public $query = '';

    public function search()
    {
        if (trim($this->query) !== '') {
            // $this->redirect('/search?q=' . urlencode($this->query));
        }
    }

    public function render()
    {
        $results = [];
        if (strlen($this->query) > 1) {
            $results = Question::where('title', 'like', '%'.$this->query.'%')
                ->limit(4)
                ->get();
        }

        return view('pages.frontend.global-search', [
            'results' => $results,
        ]);
    }
}
