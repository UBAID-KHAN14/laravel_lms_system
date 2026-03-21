<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Teacher\Course\CourseLecture;
use App\Models\User;

class CourseLecturePolicy
{
    public function update(User $user, CourseLecture $course): bool
    {
        // Admin can update anything
        if ($user->role === 'admin') {
            return true;
        }

        // Teacher can update ONLY their own course
        return $user->id === $course->section->course->teacher_id;
    }

    public function delete(User $user, CourseLecture $course): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $course->section->course->teacher_id;
    }
}