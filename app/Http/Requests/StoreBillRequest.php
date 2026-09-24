<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => [
                'required',
                'integer',
                Rule::exists('patients', 'id'),
            ],

            'appointment_id' => [
                'nullable',
                'integer',
                Rule::exists('appointments', 'id'),
            ],

            'billing_date' => [
                'required',
                'date',
            ],

            'discount_percentage' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],
        ];
    }
}