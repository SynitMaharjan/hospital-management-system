<?php

namespace App\Services;

use App\Models\Appointment;
use App\Notifications\AppointmentCreatedNotification;
use App\Notifications\AppointmentStatusUpdatedNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AppointmentService
{
    public function __construct(
        private AuditLogService $auditLogService
    ) {
    }

    /**
     * Create a new appointment.
     */
    public function create(array $data): Appointment
    {
        return DB::transaction(function () use ($data) {

            /*
             * Check if the doctor is already booked
             * at the selected date and time.
             */
            $doctorAlreadyBooked = Appointment::where(
                'doctor_id',
                $data['doctor_id']
            )
                ->where(
                    'appointment_date',
                    $data['appointment_date']
                )
                ->where(
                    'appointment_time',
                    $data['appointment_time']
                )
                ->whereIn(
                    'status',
                    ['pending', 'confirmed']
                )
                ->exists();

            if ($doctorAlreadyBooked) {
                throw ValidationException::withMessages([
                    'appointment_time' =>
                        'The doctor already has an appointment at this date and time.',
                ]);
            }

            /*
             * Check if the patient already has
             * an appointment at the same date and time.
             */
            $patientAlreadyBooked = Appointment::where(
                'patient_id',
                $data['patient_id']
            )
                ->where(
                    'appointment_date',
                    $data['appointment_date']
                )
                ->where(
                    'appointment_time',
                    $data['appointment_time']
                )
                ->whereIn(
                    'status',
                    ['pending', 'confirmed']
                )
                ->exists();

            if ($patientAlreadyBooked) {
                throw ValidationException::withMessages([
                    'appointment_time' =>
                        'The patient already has an appointment at this date and time.',
                ]);
            }

            /*
             * Create the appointment.
             */
            $appointment = Appointment::create($data);

            /*
             * Load relationships needed for
             * audit logs and notifications.
             */
            $appointment->load(
                'patient.user',
                'doctor.user'
            );

            /*
             * Create audit log.
             */
            $this->auditLogService->log(
                'created',
                "Created appointment for {$appointment->patient->full_name} with Dr. {$appointment->doctor->user->name}"
            );

            /*
             * Notify the doctor that a new appointment
             * has been created.
             */
            if ($appointment->doctor?->user) {
                $appointment->doctor->user->notify(
                    new AppointmentCreatedNotification($appointment)
                );
            }

            /*
             * If the receptionist created the appointment
             * as confirmed, notify the patient immediately.
             */
            if ($appointment->status->value === 'confirmed') {
                $this->notifyPatient($appointment);
            }

            return $appointment;
        });
    }

    /**
     * Update appointment status.
     */
    public function updateStatus(
        Appointment $appointment,
        string $status
    ): void {
        DB::transaction(function () use ($appointment, $status) {

            /*
             * Update appointment status.
             */
            $appointment->update([
                'status' => $status,
            ]);

            /*
             * Load relationships needed for
             * audit logs and notifications.
             */
            $appointment->load(
                'patient.user',
                'doctor.user'
            );

            /*
             * Create audit log.
             */
            $this->auditLogService->log(
                $status,
                ucfirst($status) .
                    " appointment for {$appointment->patient->full_name} with Dr. {$appointment->doctor->user->name}"
            );

            /*
             * Notify the patient about the status change.
             */
            $this->notifyPatient($appointment);
        });
    }

    /**
     * Notify the patient using the appropriate
     * available notification method.
     */
    private function notifyPatient(Appointment $appointment): void
    {
        /*
         * If the patient has a User account,
         * send the notification through that account.
         */
        if ($appointment->patient?->user) {

            $appointment->patient->user->notify(
                new AppointmentStatusUpdatedNotification($appointment)
            );

            return;
        }

        /*
         * If the patient does not have a User account
         * but has an email address, send the notification
         * directly to that email address.
         */
        if ($appointment->patient?->email) {

            $notifiable = (new AnonymousNotifiable)
                ->route(
                    'mail',
                    $appointment->patient->email
                );

            $notifiable->notify(
                new AppointmentStatusUpdatedNotification($appointment)
            );
        }
    }
}