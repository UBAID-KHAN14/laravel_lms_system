<?php

namespace App\Models\Teacher\Course;

use App\Models\Category;
use App\Models\CourseView;
use App\Models\Student\Course\CourseComment;
use App\Models\Student\Course\CourseReview;
use App\Models\Student\Course\Enrollment;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    protected $table = 'courses';
    protected $fillable = [
        'teacher_id',
        'category_id',
        'sub_category_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'level',
        'status',
        'published_at',
        'rejected_at',
        'rejection_reason',
    ];

    // TEACHER RELATION
    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // CATEGORY RELATION
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // SUB CATEGORY RELATION
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // SECTIONS RELATION
    public function sections()
    {
        return $this->hasMany(CourseSection::class);
    }

    // LECTURES RELATION (via sections)
    public function lectures()
    {
        return $this->hasManyThrough(
            CourseLecture::class,
            CourseSection::class,
            'course_id',
            'section_id',
            'id',
            'id'
        );
    }

    // FAQ RELATION
    public function faqs()
    {
        return $this->hasMany(FAQ::class);
    }

    public function pricing()
    {
        return $this->hasOne(Pricing::class);
    }

    // enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function myEnrollment()
    {
        return $this->hasOne(Enrollment::class)
            ->where('user_id', Auth::id());
    }

    public function canAccessEnrollment($courseId)
    {
        return $this->enrollments()
            ->where('course_id', $courseId)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->exists();
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')->withTimestamps();
    }

    // Lectures duration
    public function totalDuration()
    {
        return $this->sections()
            ->with('lectures')
            ->get()
            ->flatMap->lectures
            ->sum('duration_seconds');
    }

    public function formattedDuration()
    {
        $seconds = $this->totalDuration();

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    // COURSE REVIEWS AND COMMENTS
    public function reviews()
    {
        return $this->hasMany(CourseReview::class);
    }
    public function hasReview($courseId)
    {
        return $this->reviews()
            ->where('course_id', $courseId)
            ->exists();
    }

    public function comments()
    {
        return $this->hasMany(CourseComment::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }


    public function views()
    {
        return $this->hasMany(CourseView::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // REQUIREMENTS FOR COURSE APPROVAL
    public function canBeSubmitted(): bool
    {
        if (!$this->title || !$this->description || !$this->thumbnail) return false;
        if ($this->sections()->count() < 1) return false;

        foreach ($this->sections() as $section) {
            if ($section->lectures()->count() < 1) {
                return false;
            }
        }



        return true;
    }
}
