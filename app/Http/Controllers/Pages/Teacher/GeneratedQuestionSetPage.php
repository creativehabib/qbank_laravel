<?php

namespace App\Http\Controllers\Pages\Teacher;

use App\Http\Controllers\PageController;
use App\Models\QuestionSet;

class GeneratedQuestionSetPage extends PageController
{
    public $perPage = 10;

    public QuestionSet $questionSet;

    public $subject;

    public $chapter;

    public $topics;

    // URL থেকে পাওয়া আইডি দিয়ে কম্পোনেন্ট মাউন্ট হবে
    public function mount($qset)
    {
        // আইডি দিয়ে QuestionSet এবং এর সাথে সম্পর্কিত Class খুঁজে বের করুন
        $this->questionSet = QuestionSet::with('user')->findOrFail($qset);
        $this->subject = $this->questionSet->getRelatedSubject();
        $this->chapter = $this->questionSet->getRelatedChapter();
        $this->topics = $this->questionSet->getRelatedTopics();
    }

    public function render()
    {
        return view('pages.teacher.generated-question-set-page')
            ->layout('layouts.app');
    }
}
