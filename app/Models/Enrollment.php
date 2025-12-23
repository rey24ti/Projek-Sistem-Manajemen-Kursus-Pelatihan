<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'enrollment_date',
        'progress',
        'notes',
<<<<<<< HEAD
=======
        'payment_status',
        'final_score',
        'completion_date',
        'is_passed',
        'certificate_path',
        'certificate_number',
        'certificate_issued_at',
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
    ];

    protected $casts = [
        'enrollment_date' => 'date',
<<<<<<< HEAD
=======
        'completion_date' => 'date',
        'certificate_issued_at' => 'date',
        'final_score' => 'decimal:2',
        'is_passed' => 'boolean',
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

<<<<<<< HEAD
=======
    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class);
    }

>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'completed' => 'primary',
        ];

        return $badges[$this->status] ?? 'secondary';
    }
<<<<<<< HEAD
=======

    public function getPaymentStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => 'warning',
            'verified' => 'success',
            'rejected' => 'danger',
        ];

        return $badges[$this->payment_status] ?? 'secondary';
    }
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
}
