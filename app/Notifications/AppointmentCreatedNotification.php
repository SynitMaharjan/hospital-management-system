<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Appointment $appointment
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Appointment Assigned')
            ->greeting("Hello Dr. {$notifiable->name},")
            ->line('A new appointment has been assigned to you.')
            ->line("Patient: {$this->appointment->patient->user->name}")
            ->line("Date: {$this->appointment->appointment_date}")
            ->line("Time: {$this->appointment->appointment_time}")
            ->line("Reason: {$this->appointment->reason}")
            ->action('View Appointment', url("/doctor/appointment/{$this->appointment->id}"))
            ->line('Please check your hospital account for more details.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'patient_name' => $this->appointment->patient->user->name,
            'appointment_date' => $this->appointment->appointment_date->format('Y-m-d'),
            'appointment_time' => $this->appointment->appointment_time->format('H:i'),
        ];
    }
}