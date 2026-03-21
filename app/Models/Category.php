<?php

namespace App\Models;

use App\Models\Teacher\Course\Course;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    // COURSES RELATION
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
