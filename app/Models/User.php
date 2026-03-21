<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Student\Course\Enrollment;
use App\Models\Teacher\Course\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'requested_as',
        'status',
        'is_active',
        'gender',
        'phone',
        'image',
        'qualification',
        'experience',
        'roll_number',
        'father_name',
        'class_name',
    ];

    // COURSES
    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }



    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // this model define the relation b/w this user model and course model
    // through a pivot table called enrollments
    // one student have may courses, one course have many students
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')->withTimestamps();
    }

    // if the student enrolled to that course
    public function hasEnrolled($courseId)
    {
        return $this->enrollments()->where('course_id', $courseId)->exists();
    }



    public function canAccessCourse($courseId)
    {
        return $this->enrollments()
            ->where('course_id', $courseId)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->exists();
    }


    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }


    public function chatbots()
    {
        return $this->hasMany(Chatbot::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
