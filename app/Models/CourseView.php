<?php

namespace App\Models;

use App\Models\Teacher\Course\Course;
use Illuminate\Database\Eloquent\Model;

class CourseView extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'ip_address',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
