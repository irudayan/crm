<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeUserNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello ' . $this->user->name . '!')
            ->line('Your account has been created successfully.')
            ->line('Email: ' . $this->user->email)
            ->line('Password: ' . $this->password) // show plain password
            ->action('Login Here', url('/login'))
            ->line('Thank you for using our application!');
    }
}
