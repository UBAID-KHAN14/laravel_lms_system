<?php

namespace App\Models\Teacher\Course;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $table = 'course_sections';
    protected $fillable = [
        'course_id',
        'title',
        'order_number',
    ];

    // COURSE RELATION
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // LECTURES RELATION
    public function lectures()
    {
        return $this->hasMany(CourseLecture::class, 'section_id');
    }
}
