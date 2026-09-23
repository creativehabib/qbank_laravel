<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Organization extends Model
{
    protected $fillable = ['name', 'short_name', 'slug', 'logo_path', 'description', 'official_website', 'established_year'];

    public function pastExams(): HasMany
    {
        return $this->hasMany(PastExam::class);
    }

    public function getLogoUrlAttribute()
    {
        if (! $this->logo_path) {
            return null;
        }

        if (str_starts_with($this->logo_path, 'http')) {
            return $this->logo_path;
        }

        return Storage::url($this->logo_path);
    }
}
