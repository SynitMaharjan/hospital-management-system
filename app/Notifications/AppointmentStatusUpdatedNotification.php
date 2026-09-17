<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Appointment $appointment
    ) {
    }

    /**
     * Determine which notification channels should be used.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the email notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $status = $this->appointment->status->value;

        $statusLabel = ucfirst($status);

        $actionText = match ($status) {
            'confirmed' => 'approved and confirmed',
            'cancelled' => 'cancelled',
            'completed' => 'marked as completed',
            default => "updated to {$statusLabel}",
        };

        $patientName = $this->appointment->patient->full_name;

        $doctorName = $this->appointment->doctor->user->name;

        return (new MailMessage)
            ->subject("Appointment {$statusLabel}")

            ->greeting("Hello {$patientName},")

            ->line(
                "Your appointment has been {$actionText} by Dr. {$doctorName}."
            )

            ->line("**Appointment Details:**")

            ->line(
                "Doctor: Dr. {$doctorName}"
            )

            ->line(
                "Date: {$this->appointment->appointment_date->format('Y-m-d')}"
            )

            ->line(
                "Time: {$this->appointment->appointment_time->format('H:i')}"
            )

            ->line(
                "Reason: {$this->appointment->reason}"
            )

            ->line(
                "Status: {$statusLabel}"
            )

            ->when(
                $status === 'confirmed',
                fn ($msg) => $msg->line(
                    'Please arrive 15 minutes before your scheduled time.'
                )
            )

            ->when(
                $status === 'cancelled',
                fn ($msg) => $msg->line(
                    'You may book a new appointment at your convenience.'
                )
            )

            ->action(
                'View Appointment',
                url("/patient/appointment/{$this->appointment->id}")
            )

            ->line(
                'Thank you for using our hospital management system.'
            );
    }

    /**
     * Data stored for database notifications.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,

            'doctor_name' => $this->appointment->doctor->user->name,

            'appointment_date' => $this->appointment
                ->appointment_date
                ->format('Y-m-d'),

            'appointment_time' => $this->appointment
                ->appointment_time
                ->format('H:i'),

            'status' => $this->appointment->status->value,
        ];
    }
}