<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verifyUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Account on EZ-Bus')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Thank you for registering at EZ-Bus.')
            ->line('Please click the button below to verify your email address.')
            ->action('Verify Email', $verifyUrl)
            ->line('If you didn\'t create an account, no further action is required.')
            ->salutation('Regards, EZ-Bus Team');
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
