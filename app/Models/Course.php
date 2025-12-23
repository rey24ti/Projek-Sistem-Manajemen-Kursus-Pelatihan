<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'trainer_id',
        'start_date',
        'end_date',
        'max_participants',
        'status',
        'price',
        'image',
<<<<<<< HEAD
=======
        'passing_score',
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(CourseMaterial::class);
    }

<<<<<<< HEAD
=======
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'draft' => 'secondary',
            'open' => 'success',
            'ongoing' => 'info',
            'completed' => 'primary',
            'cancelled' => 'danger',
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}
