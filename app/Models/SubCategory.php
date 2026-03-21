<?php

namespace App\Models;

use App\Models\Teacher\Course\Course;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';

    protected $fillable = [
        'category_id',
        'name',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // COURSES
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
