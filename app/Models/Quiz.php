<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'questions',
        'time_limit',
        'passing_score',
        'start_date',
        'end_date',
        'order',
    ];

    protected $casts = [
        'questions' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
