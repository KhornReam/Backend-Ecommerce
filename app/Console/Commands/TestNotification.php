<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\UserLoginNotification;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:test-notification')]
#[Description('Test login notification')]
class TestNotification extends Command
{
    public function handle()
    {
        $admin = User::where('email', 'admin2@gmail.com')->first();
        
        if (!$admin) {
            $this->error('Admin2 not found');
            return 1;
        }

        $notification = new UserLoginNotification('Test User', 'test@example.com', '127.0.0.1', 'Mozilla/5.0');
        $admin->notify($notification);
        
        $this->info('Notification sent!');
        $this->info('Unread count: ' . $admin->unreadNotifications->count());
        
        return 0;
    }
}
