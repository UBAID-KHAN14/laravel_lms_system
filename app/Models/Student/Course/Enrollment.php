<?php

namespace App\Models\Student\Course;

use App\Models\Teacher\Course\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrollments';
    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'status',
        'is_active',
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
