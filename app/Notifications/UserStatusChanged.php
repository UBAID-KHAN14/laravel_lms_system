<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $status
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return match ($this->status) {
            'approved' => (new MailMessage)
                ->subject('Your Account Has Been Approved 🎉')
                ->greeting('Hello ' . $notifiable->name)
                ->line('Good news! Your account has been approved.')
                ->action('Login Now', url('/login'))
                ->line('Welcome aboard!'),

            'blocked' => (new MailMessage)
                ->subject('Your Account Has Been Blocked')
                ->greeting('Hello ' . $notifiable->name)
                ->line('Your account has been blocked by the administrator.')
                ->line('If you believe this is a mistake, please contact support.'),

            'rejected' => (new MailMessage)
                ->subject('Your Account Has Been Rejected')
                ->greeting('Hello ' . $notifiable->name)
                ->line('Your account has been rejected by the administrator.')
                ->line('If you believe this is a mistake, please contact support.'),

            default => (new MailMessage)
                ->subject('Account Status Update')
                ->line('Your account status has been updated.'),
        };
    }
}
