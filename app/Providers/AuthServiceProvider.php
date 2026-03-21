<?php

namespace App\Providers;


use App\Models\Teacher\Course\Course;
use App\Models\Teacher\Course\CourseLecture;
use App\Models\Teacher\Course\CourseSection;
use App\Models\Teacher\Course\FAQ;
use App\Models\Teacher\Course\LectureMaterial;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Course::class => \App\Policies\CoursePolicy::class,
        CourseSection::class => \App\Policies\CourseSectionPolicy::class,
        CourseLecture::class => \App\Policies\CourseLecturePolicy::class,
        LectureMaterial::class => \App\Policies\CourseLectureMaterialPolicy::class,
        FAQ::class => \App\Policies\CourseFaqPolicy::class,

    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin', fn($user) => $user->role === 'admin');
        Gate::define('teacher', fn($user) => $user->role === 'teacher');
        Gate::define('student', fn($user) => $user->role === 'student');
        Gate::define('has-course', function ($user) {
            return $user->courses()->exists();
        });
        Gate::define('has-sections', function ($user) {
            return $user->courses()->whereHas('sections')->exists();
        });
        Gate::define('has-lectures', function ($user) {
            return $user->courses()->whereHas('sections.lectures')->exists();
        });
        Gate::define('has-materials', function ($user) {
            return $user->courses()->whereHas('sections.lectures.materials')->exists();
        });
    }
}
