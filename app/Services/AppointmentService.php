<?php

namespace App\Services;

use App\Models\Appointment;
use App\Notifications\AppointmentCreatedNotification;
use App\Notifications\AppointmentStatusUpdatedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\AuditLogService;

class AppointmentService
{
    public function __construct(
        private AuditLogService $auditLogService
    ) {}

    public function create(array $data): Appointment
    {
        return DB::transaction(function () use ($data) {

            $alreadyBooked = Appointment::where('doctor_id', $data['doctor_id'])
                ->where('appointment_date', $data['appointment_date'])
                ->where('appointment_time', $data['appointment_time'])
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();

            if ($alreadyBooked) {
                throw ValidationException::withMessages([
                    'appointment_time' =>
                        'The doctor already has an appointment at this date and time.',
                ]);
            }

            $appointment = Appointment::create($data);

            $appointment->load('patient.user', 'doctor.user');
           
            $this->auditLogService->log(
                'created',
                "Created appointment for {$appointment->patient->user->name} with Dr. {$appointment->doctor->user->name}"
            );

            if ($appointment->doctor?->user) {
                $appointment->doctor->user->notify(
                    new AppointmentCreatedNotification($appointment)
                );
            }

            return $appointment;
        });
    }

    public function updateStatus(
        Appointment $appointment,
        string $status
    ): void {
        DB::transaction(function () use ($appointment, $status) {

            $appointment->update([
                'status' => $status,
            ]);

            $appointment->load('patient.user', 'doctor.user');
    
            $this->auditLogService->log(
                $status,
                ucfirst($status) .
                    " appointment for {$appointment->patient->user->name} with Dr. {$appointment->doctor->user->name}"
            );  

            if ($appointment->patient?->user) {
                $appointment->patient->user->notify(
                    new AppointmentStatusUpdatedNotification($appointment)
                );
            }
        });
    }
    
}