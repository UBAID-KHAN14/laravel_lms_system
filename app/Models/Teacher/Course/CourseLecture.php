<?php

namespace App\Models\Teacher\Course;

use Illuminate\Database\Eloquent\Model;

class CourseLecture extends Model
{
    protected $table = 'course_lectures';
    protected $fillable = [
        'section_id',
        'title',
        'description',
        'video_url',
        'video_file',
        'is_preview',
    ];

    // SECTION RELATION
    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'section_id');
    }

    // MATERIALS RELATION
    public function materials()
    {
        return $this->hasMany(LectureMaterial::class, 'lecture_id');
    }
}
