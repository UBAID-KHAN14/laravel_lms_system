<?php

namespace App\Models\Teacher\Course;

use Illuminate\Database\Eloquent\Model;

class LectureMaterial extends Model
{
    protected $table = 'lecture_materials';
    protected $fillable = [
        'lecture_id',
        'file_name',
        'file_path',
        'file_type',
    ];

    public function lecture()
    {
        return $this->belongsTo(CourseLecture::class,);
    }
}
