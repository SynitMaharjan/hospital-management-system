<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\AppointmentStatus;

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
            "appointment_date" => "required|date|after_or_equal:today",
            "appointment_time" => "required|date_format:H:i",
            "status" => "nullable|in:pending,confirmed",
            "reason" => "required|string|max:255",
        ];
    }
}