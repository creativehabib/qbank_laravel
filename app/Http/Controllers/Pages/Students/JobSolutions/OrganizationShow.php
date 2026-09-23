<?php

namespace App\Http\Controllers\Pages\Students\JobSolutions;

use App\Http\Controllers\PageController;
use App\Http\Controllers\Concerns\InteractsWithPagination;
use App\Models\Organization;

class OrganizationShow extends PageController
{
    use InteractsInteractsWithPagination;

    public $organization;

    public $type = 'all';

    public function mount($organizationSlug)
    {
        $this->organization = Organization::where('slug', $organizationSlug)->firstOrFail();
    }

    public function setType($type)
    {
        $this->type = $type;
        $this->resetPage();
    }

    public function render()
    {
        $query = $this->organization->pastExams()->with('examCategory')->withCount('questions');
        if ($this->type !== 'all') {
            $query->where('type', $this->type);
        }
        $exams = $query->latest('exam_date')->paginate(15);

        return view('frontend.job-solutions.organization-show', [
            'exams' => $exams,
        ])->layout('layouts.frontend', ['title' => $this->organization->name.' - জব সলিউশন']);
    }
}
