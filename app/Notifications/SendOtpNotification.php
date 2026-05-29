<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpNotification extends Notification
{
    use Queueable;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Verification Code')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your password reset verification code is:')
            ->line("**{$this->code}**")
            ->line('This code expires in 15 minutes.')
            ->line('If you did not request this, please ignore this email.')
            ->line('Thank you for using our application!');
    }
}