<?php

namespace App\Http\Controllers\Pages\Admin\PastExams;

use App\Http\Controllers\PageController;
use App\Http\Controllers\Concerns\InteractsWithPagination;
use App\Models\PastExam;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Tag;
use Illuminate\Support\Str;

class PastExamManager extends PageController
{
    use InteractsWithPagination;

    public $pastExamId;

    public $exam;

    // Simplified Search Filters
    public $searchQuery = '';

    public $searchSubject = '';

    public $searchTag = '';

    public $searchType = ''; // MCQ or Written

    // Simplified Quick Create Modal Properties
    public $quickSubject = '';

    public $quickType = 'mcq';

    public $quickTitle = '';

    public $quickOptions = [
        ['text' => '', 'is_correct' => true],
        ['text' => '', 'is_correct' => false],
        ['text' => '', 'is_correct' => false],
        ['text' => '', 'is_correct' => false],
    ];

    public $showQuickModal = false;

    public function mount($pastExamId)
    {
        $this->pastExamId = $pastExamId;
        $this->exam = PastExam::with('questions', 'organization', 'examCategory')->findOrFail($pastExamId);
    }

    public function attachQuestion($questionId)
    {
        if (! $this->exam->questions()->where('question_id', $questionId)->exists()) {
            $this->exam->questions()->attach($questionId, ['order' => $this->exam->questions()->count() + 1]);
            $this->exam->refresh();
        }
    }

    public function detachQuestion($questionId)
    {
        $this->exam->questions()->detach($questionId);
        $this->exam->refresh();
    }

    public function setCorrectOption($index)
    {
        foreach ($this->quickOptions as $k => $opt) {
            $this->quickOptions[$k]['is_correct'] = ($k == $index);
        }
    }

    public function saveQuickQuestion()
    {
        $this->validate([
            'quickSubject' => 'required|exists:subjects,id',
            'quickTitle' => 'required|string',
            'quickType' => 'required|in:mcq,cq,short,written',
        ]);

        if ($this->quickType === 'mcq') {
            $this->validate([
                'quickOptions.*.text' => 'required|string',
            ]);
        }

        $extraContent = null;
        if ($this->quickType === 'mcq') {
            $extraContent = array_map(function ($opt) {
                return ['option_text' => $opt['text'], 'is_correct' => $opt['is_correct']];
            }, $this->quickOptions);
        }

        $question = Question::create([
            'title' => $this->quickTitle,
            'slug' => Str::slug(Str::limit(strip_tags($this->quickTitle), 50)).'-'.uniqid(),
            'subject_id' => $this->quickSubject,
            'question_type' => $this->quickType,
            'extra_content' => $extraContent,
            'difficulty' => 'easy',
            'marks' => $this->quickType === 'mcq' ? 1 : 2,
            'user_id' => auth()->id(),
        ]);

        $this->attachQuestion($question->id);
        $this->showQuickModal = false;

        $this->reset(['quickTitle', 'quickType']);
        $this->quickOptions = [
            ['text' => '', 'is_correct' => true],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
        ];
    }

    public function render()
    {
        $subjects = Subject::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        $searchResults = collect();
        if (strlen($this->searchQuery) >= 2 || $this->searchSubject != '' || $this->searchTag != '' || $this->searchType != '') {
            $query = Question::query();

            if ($this->searchQuery) {
                $query->where('title', 'like', '%'.$this->searchQuery.'%')
                    ->orWhere('id', $this->searchQuery);
            }
            if ($this->searchSubject) {
                $query->where('subject_id', $this->searchSubject);
            }
            if ($this->searchType) {
                $query->where('question_type', $this->searchType);
            }
            if ($this->searchTag) {
                $query->whereHas('tags', function ($q) {
                    $q->where('tags.id', $this->searchTag);
                });
            }

            // Exclude already attached questions
            $query->whereNotIn('id', $this->exam->questions->pluck('id'));

            $searchResults = $query->limit(30)->get();
        }

        return view('pages.admin.past-exams.past-exam-manager', [
            'subjects' => $subjects,
            'tags' => $tags,
            'searchResults' => $searchResults,
        ])->layout('layouts.app', ['title' => 'Manage Exam Questions']);
    }
}
