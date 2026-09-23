<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExistingPatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_number' => [
                'required',
                'string',
                'exists:patients,patient_number',
            ],

            'email' => [
                'required',
                'email',
            ],
        ];
    }
}