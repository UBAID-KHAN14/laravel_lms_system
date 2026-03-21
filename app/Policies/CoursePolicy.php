<?php

namespace App\Policies;

use App\Models\Teacher\Course\Course as TeacherCourse;
use App\Models\User;

class CoursePolicy
{
    public function update(User $user, TeacherCourse $course): bool
    {
        // Admin can update anything
        if ($user->role === 'admin') {
            return true;
        }

        // Teacher can update ONLY their own course
        return $user->id === $course->teacher_id;
    }

    public function delete(User $user, TeacherCourse $course): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $course->teacher_id;
    }
}
