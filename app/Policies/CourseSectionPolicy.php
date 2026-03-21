<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Teacher\Course\CourseSection as TeacherCourse;
use App\Models\User;

class CourseSectionPolicy
{
    public function update(User $user, TeacherCourse $courseSection): bool
    {
        // Admin can update anything
        if ($user->role === 'admin') {
            return true;
        }

        // Teacher can update ONLY their own course section
        return $user->id === $courseSection->course->teacher_id;
    }

    public function delete(User $user, TeacherCourse $courseSection): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $courseSection->course->teacher_id;
    }
}
