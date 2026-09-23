<?php

namespace App\Notifications;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExistingPatientOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Patient $patient,
        public string $otp
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('HMS - Patient Verification Code')
            ->greeting('Hello ' . $this->patient->fullName . '!')
            ->line('We received a request to create an online account for your existing hospital patient record.')
            ->line('Your verification code is:')
            ->line($this->otp)
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not request this, you can safely ignore this email.')
            ->salutation('Regards, HMS Team');
    }
}