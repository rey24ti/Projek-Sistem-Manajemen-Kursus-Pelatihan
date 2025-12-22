<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    protected $fillable = [
        'user_id',
        'assignment_id',
        'quiz_id',
        'file_path',
        'file_name',
        'answers',
        'score',
        'feedback',
        'status',
        'submitted_at',
        'graded_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'score' => 'decimal:2',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
