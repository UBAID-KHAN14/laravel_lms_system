<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Teacher\Course\LectureMaterial;
use App\Models\User;

class CourseLectureMaterialPolicy
{
    public function update(User $user, LectureMaterial $material): bool
    {
        // Admin can update anything
        if ($user->role === 'admin') {
            return true;
        }

        // Teacher can update ONLY their own course
        return $user->id === $material->lecture->section->course->teacher_id;
    }

    public function delete(User $user, LectureMaterial $material): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $material->lecture->section->course->teacher_id;
    }
}
