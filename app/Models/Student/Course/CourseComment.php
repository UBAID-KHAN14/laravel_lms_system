<?php

namespace App\Models\Student\Course;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CourseComment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'parent_id',
        'comment'
    ];

    // Parent comment
    public function parent()
    {
        return $this->belongsTo(CourseComment::class, 'parent_id');
    }

    // Replies
    public function replies()
    {
        return $this->hasMany(CourseComment::class, 'parent_id')
            ->with('replies.user');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}