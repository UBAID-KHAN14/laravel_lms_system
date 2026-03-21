<?php

namespace App\Models\Teacher\Course;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $table = 'course_pricings';
    protected $fillable = [
        'course_id',
        'price',
        'currency',
        'currency_symbol',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
