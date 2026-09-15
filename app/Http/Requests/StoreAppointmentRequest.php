<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "patient_id" => "required|exists:patients,id",
            "doctor_id" => "required|exists:doctors,id",
            "appointment_date" => [
                "required",
                "date",
                "after_or_equal:today",
            ],
            "appointment_time" => [
                "required",
                "date_format:H:i",
                function (string $attribute, mixed $value, Closure $fail) {
                    $minutes = (int) date('i', strtotime($value));

                    if ($minutes !== 0 && $minutes !== 30) {
                        $fail("Appointment time must be in 30-minute intervals.");
                    }
                },
            ],
            "status" => "nullable|in:pending,confirmed",
            "reason" => "required|string|max:255",
        ];
    }
}
