<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PastExam extends Model
{
    protected $fillable = [
        'title', 'slug', 'organization_id', 'exam_category_id', 'exam_date',
        'grade', 'total_marks', 'total_questions', 'duration', 'description', 'type', 'thumbnail',
    ];

    protected $casts = [
        'exam_date' => 'date',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function examCategory(): BelongsTo
    {
        return $this->belongsTo(ExamCategory::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'past_exam_question')
            ->withPivot('order')
            ->orderByPivot('order');
    }
}
