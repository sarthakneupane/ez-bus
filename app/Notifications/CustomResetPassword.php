<?php 
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class CustomResetPassword extends Notification
{
    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = $this->resetUrl();

        return (new MailMessage)
            ->subject('Reset Your Password - EZ-Bus')
            ->greeting('Hello!')
            ->line('We received a request to reset your password. Click the button below to reset it.')
            ->action('Reset Password', $resetUrl)
            ->line('This password reset link will expire in 60 minutes.')
            ->line('If you did not request a password reset, no action is required.')
            ->salutation('Regards, EZ-Bus Team');
    }

    protected function resetUrl()
    {
        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $this->email
        ], false));
    }
}
