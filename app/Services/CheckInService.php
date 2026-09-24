<?php

namespace App\Services;

use App\Models\CheckIn;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Enums\CheckInStatus;

class CheckInService
{
    /**
     * Check in a patient for an appointment.
     */
    public function checkIn(array $data): CheckIn
    {
        return DB::transaction(function () use ($data) {
            $appointmentId = $data['appointment_id'];

            // Verify the appointment exists and is confirmed for today
            $appointment = Appointment::with('patient')
                ->findOrFail($appointmentId);

            // Additional checks (though already validated in request)
            $today = now()->toDateString();
            if ($appointment->appointment_date->toDateString() !== $today) {
                throw ValidationException::withMessages([
                    'appointment_id' => 'The appointment is not for today.',
                ]);
            }

            if ($appointment->status->value !== 'confirmed') {
                throw ValidationException::withMessages([
                    'appointment_id' => 'The appointment is not confirmed.',
                ]);
            }

            // Check if already checked in
            $existingCheckIn = CheckIn::where('appointment_id', $appointmentId)->first();
            if ($existingCheckIn) {
                throw ValidationException::withMessages([
                    'appointment_id' => 'This appointment has already been checked in.',
                ]);
            }

            // Create the check-in record
            $checkIn = CheckIn::create([
                'appointment_id' => $appointmentId,
                'patient_id' => $appointment->patient_id,
                'checked_in_at' => now(),
                'status' => \App\Enums\CheckInStatus::WAITING->value,
            ]);

            return $checkIn;
        });
    }

    /**
     * Update the check-in status.
     */
    public function updateStatus(CheckIn $checkIn, CheckInStatus $status): void
    {
        DB::transaction(function () use ($checkIn, $status) {
            $checkIn->update([
                'status' => $status->value,
            ]);
        });
    }

    /**
     * Check out a patient (mark check-in as completed).
     */
    public function checkOut(CheckIn $checkIn): void
    {
        $this->updateStatus($checkIn, CheckInStatus::COMPLETED);
    }
}