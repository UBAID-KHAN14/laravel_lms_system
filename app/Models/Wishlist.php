<?php

namespace App\Models;

use App\Models\Teacher\Course\Course;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}