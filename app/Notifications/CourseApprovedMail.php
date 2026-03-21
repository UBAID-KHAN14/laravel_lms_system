<?php

namespace App\Notifications;

use App\Models\Teacher\Course\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseApprovedMail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Course $course) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        // Approved
        if ($this->course->status === 'published') {
            return (new MailMessage)
                ->subject('Your Course Has Been Approved 🎉')
                ->greeting('Hello ' . $notifiable->name . ',')
                ->line('Good news! Your course "' . $this->course->title . '" has been approved and is now live on our platform.')
                ->action('View Course', url('/teacher/courses'))
                ->line('Thank you for contributing to our learning community!');
        }

        // Rejected
        if ($this->course->status === 'rejected') {
            return (new MailMessage)
                ->subject('Your Course Has Been Rejected')
                ->greeting('Hello ' . $notifiable->name . ',')
                ->line('We reviewed your course "' . $this->course->title . '" and it was rejected.')
                ->line('Reason: ' . ($this->course->rejection_reason ?? 'Not specified'))
                ->action('Edit Course', url('/teacher/courses/edit/' . $this->course->id))
                ->line('You can update the course and resubmit it for review.');
        }

        // Default fallback
        return (new MailMessage)
            ->subject('Course Status Updated')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('The status of your course "' . $this->course->title . '" has been updated to: ' . $this->course->status)
            ->action('View Courses', url('/teacher/courses'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
