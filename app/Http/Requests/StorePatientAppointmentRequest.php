<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;

class StorePatientAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only authenticated patients can book appointments
        return auth()->check() && auth()->user()->role === \App\Enums\Role::PATIENT;
    }

    public function rules(): array
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],
            'doctor_id' => ['required', 'exists:doctors,id', function ($attribute, $value, Closure $fail) {
                $departmentId = $this->input('department_id');
                $doctor = \App\Models\Doctor::find($value);
                if ($doctor && $doctor->department_id != (int)$departmentId) {
                    $fail('The selected doctor does not belong to the selected department.');
                }
            }],
            'appointment_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'appointment_time' => [
                'required',
                'date_format:H:i',
                function (string $attribute, mixed $value, Closure $fail) {
                    $minutes = (int) date('i', strtotime($value));
                    if ($minutes !== 0 && $minutes !== 30) {
                        $fail('Appointment time must be in 30-minute intervals.');
                    }
                },
            ],
            'reason' => 'required|string|max:255',
        ];
    }
}