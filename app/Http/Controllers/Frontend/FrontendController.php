<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\PastExam;
use App\Models\Question;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        // Fetch 6 most recently added exams
        $recentExams = PastExam::with('organization')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        // Fetch Top 15 organizations (with at least 1 exam)
        $topOrganizations = Organization::withCount('pastExams')
            ->having('past_exams_count', '>', 0)
            ->orderBy('past_exams_count', 'desc')
            ->take(15)
            ->get();

        return view('welcome', compact('recentExams', 'topOrganizations'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $results = null;

        if (! empty($query) && strlen($query) > 1) {
            $results = Question::where('title', 'like', '%'.$query.'%')
                ->paginate(20);
        }

        return view('frontend.search', compact('results', 'query'));
    }

    public function apiSearch(Request $request)
    {
        $query = $request->input('q');
        $results = [];

        if (! empty($query) && strlen($query) > 1) {
            $results = Question::where('title', 'like', '%'.$query.'%')
                ->limit(5)
                ->get()
                ->map(function ($q) {
                    return [
                        'title' => strip_tags(preg_replace('/<a\b[^>]*>(.*?)<\/a>/i', '<span>$1</span>', $q->title)),
                        'slug' => $q->slug,
                    ];
                });
        }

        return response()->json(['results' => $results]);
    }
}
