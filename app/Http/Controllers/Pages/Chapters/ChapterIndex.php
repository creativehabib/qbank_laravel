<?php

namespace App\Http\Controllers\Pages\Chapters;

use App\Http\Controllers\PageController;
use App\Http\Controllers\Concerns\InteractsWithPagination;
use App\Http\Controllers\Pages\Traits\InteractsWithToasts;
use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Support\Str;

class ChapterIndex extends PageController
{
    public $toggleTargetId = null;

    public $toggleTargetName = '';

    public $toggleTargetState = false;

    public $showToggleModal = false;

    public $isCreating = false;

    public $perPage = 10;

    public $sortField = 'default';

    use InteractsWithToasts;
    use InteractsInteractsWithPagination;

    public string $search = '';

    // Form Properties
    public $editId = null;

    public string $subject_id = '';

    public string $name = '';

    public $slug = '';

    public ?string $description = '';

    public bool $is_active = true;

    public bool $is_premium = false;

    public $image;

    protected $listeners = ['deleteSubjectConfirmed' => 'delete'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function cancelEdit()
    {
        $this->isCreating = false;
        $this->reset([
            'editId', 'subject_id', 'name', 'slug',
            'description', 'image',
        ]);
        $this->is_active = true;
        $this->is_premium = false;
        $this->resetValidation();
    }

    public function openModal()
    {
        $this->cancelEdit();
        $this->dispatch('open-chapter-modal');
    }

    public function edit($id)
    {
        $this->isCreating = false;
        $this->resetValidation();
        $chapter = Chapter::withCount('questions')->with('subject.academicClasses')->findOrFail($id);

        $this->editId = $chapter->id;
        $this->subject_id = (string) $chapter->subject_id;

        $this->name = $chapter->name;
        $this->slug = $chapter->slug;
        $this->description = $chapter->description ?? '';
        $this->is_active = $chapter->is_active;
        $this->is_premium = $chapter->is_premium;
        $this->image = $chapter->image;

        // ডেটা লোড হওয়ার পর মডাল ওপেন হবে
        $this->dispatch('open-chapter-modal');
    }

    public function updatedName($value)
    {
        if (empty($this->editId)) {
            $this->slug = preg_replace('/\s+/u', '-', trim($value));
        }
    }

    public function save()
    {
        if (empty($this->slug)) {
            $this->slug = preg_replace('/\s+/u', '-', trim($this->name));
        }

        $validated = $this->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:chapters,slug,'.$this->editId,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_premium' => 'boolean',
            'image' => 'nullable|string',
        ]);

        $subject = Subject::find($validated['subject_id']);

        if (! $subject) {
            $this->addError('subject_id', 'Invalid subject.');

            return;
        }

        $data = [
            'subject_id' => $subject->id,
            'name' => $this->name,
            'slug' => preg_replace('/\s+/u', '-', trim($this->slug)),
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_premium' => $this->is_premium,
            'image' => $this->image,
        ];

        if ($this->editId) {
            Chapter::where('id', $this->editId)->update($data);
            $message = 'Chapter updated successfully!';
        } else {
            $data['uuid'] = (string) Str::uuid();
            $data['order_sequence'] = Chapter::max('order_sequence') + 1 ?? 1;
            Chapter::create($data);
            $message = 'Chapter created successfully!';
        }

        // সেভ হওয়ার পর মডাল বন্ধের সিগন্যাল এবং টোস্ট মেসেজ
        $this->dispatch('close-chapter-modal');
        $this->dispatch('chapterSaved', message: $message);
        $this->toastSuccess($message);
        $this->cancelEdit();
    }

    public function delete($id)
    {
        $chapter = Chapter::find($id);
        if ($chapter) {
            $hasQuestions = Question::where('chapter_id', $id)->exists();
            if ($hasQuestions) {
                $this->toastWarning('This chapter is attached to questions, so it cannot be deleted. You can deactivate it instead.', 'Cannot Delete');

                return;
            }

            $chapter->delete();
            $this->resetPage();
            $this->dispatch('subjectDeleted', message: 'Chapter deleted successfully.');
            $this->toastSuccess('Chapter deleted successfully.');
        }
    }

    public function toggleActive($id)
    {
        $item = Chapter::findOrFail($id);
        $this->toggleTargetId = $id;
        $this->toggleTargetName = $item->name;
        $this->toggleTargetState = ! $item->is_active;

        // Open modal via the page UI
        $this->showToggleModal = true;
        $this->dispatch('modal-show', name: 'toggle-confirm');
    }

    public function performToggle()
    {
        if (! $this->toggleTargetId) {
            return;
        }

        $item = Chapter::findOrFail($this->toggleTargetId);
        $item->is_active = $this->toggleTargetState;
        $item->save();

        $this->toastSuccess('Status updated successfully.');
        $this->showToggleModal = false;
        $this->dispatch('modal-close', name: 'toggle-confirm');
        $this->toggleTargetId = null;
    }

    public function create()
    {
        $this->cancelEdit();
        $this->isCreating = true;
    }

    public function render()
    {
        $chapters = Chapter::withCount('questions')->with('subject.academicClasses')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->when($this->sortField === 'name_asc', fn ($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortField === 'name_desc', fn ($q) => $q->orderBy('name', 'desc'))
            ->when($this->sortField === 'default', fn ($q) => $q->latest())
            ->paginate($this->perPage);

        $subjects = Subject::query()
            ->orderBy('name')
            ->when($this->sortField === 'name_asc', fn ($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortField === 'name_desc', fn ($q) => $q->orderBy('name', 'desc'))
            ->when($this->sortField === 'default', fn ($q) => $q->latest())
            ->get();

        $classes = AcademicClass::query()->withCount('questions')->when($this->sortField === 'name_asc', fn ($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortField === 'name_desc', fn ($q) => $q->orderBy('name', 'desc'))
            ->when($this->sortField === 'default', fn ($q) => $q->latest())->get();

        return view('pages.chapters.chapter-index', compact('chapters', 'subjects', 'classes'))
            ->layout('layouts.app', ['title' => 'Manage Chapters']);
    }
}
