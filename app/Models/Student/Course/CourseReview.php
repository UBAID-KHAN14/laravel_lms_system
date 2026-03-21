<?php

namespace App\Models\Student\Course;

use App\Models\Teacher\Course\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CourseReview extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'rating',
        'review'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}