<?php

namespace App\Models\Teacher\Course;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $table = 'faqs';
    protected $fillable = [
        'course_id',
        'question',
        'answer',
    ];

    // COURSE RELATION
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
