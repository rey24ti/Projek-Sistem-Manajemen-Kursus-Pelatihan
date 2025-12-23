<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseMaterial extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
<<<<<<< HEAD
=======
        'video_url',
        'material_type',
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
        'order',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
