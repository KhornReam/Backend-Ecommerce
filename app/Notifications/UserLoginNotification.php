<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class UserLoginNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $userName,
        public string $userEmail,
        public string $ipAddress,
        public string $userAgent
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New User Login',
            'message' => "User {$this->userName} ({$this->userEmail}) logged in",
            'icon' => 'login',
            'user_name' => $this->userName,
            'user_email' => $this->userEmail,
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
            'logged_in_at' => now()->toDateTimeString(),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
