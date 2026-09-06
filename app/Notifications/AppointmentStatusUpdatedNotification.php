<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentStatusUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Appointment $appointment
    ) {
    }

    public function via(object $notifiable): array
    {
        return ["mail"];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $status = $this->appointment->status->value;

        return (new MailMessage)
            ->subject("Appointment Status Updated")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your appointment status has been updated.")
            ->line("Doctor: {$this->appointment->doctor->user->name}")
            ->line("Date: {$this->appointment->appointment_date}")
            ->line("Time: {$this->appointment->appointment_time}")
            ->line("Status: " . ucfirst($status))
            ->line("Reason: {$this->appointment->reason}")
            ->line("Please check your hospital account for more details.");
    }
}