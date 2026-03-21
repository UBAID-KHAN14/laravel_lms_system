<?php


namespace App\Policies;

use App\Models\User;
use App\Models\CourseFaq;
use App\Models\Teacher\Course\FAQ;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseFaqPolicy
{
    use HandlesAuthorization;

    public function view(User $user, FAQ $faq)
    {
        return $user->id === $faq->course->teacher_id;
    }

    public function create(User $user)
    {
        return $user->hasRole('teacher'); // adjust to your app's role check
    }

    public function update(User $user, FAQ $faq)
    {
        return $user->id === $faq->course->teacher_id;
    }

    public function delete(User $user, FAQ $faq)
    {
        return $user->id === $faq->course->teacher_id;
    }
}
