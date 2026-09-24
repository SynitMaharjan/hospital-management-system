<?php

namespace App\Http\Requests;

use App\Enums\BloodGroup;
use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s.\'-]+$/u',
            ],

            'middle_name' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[\pL\s.\'-]+$/u',
            ],

            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s.\'-]+$/u',
            ],

            'phone' => [
                'required',
                'string',
                'regex:/^(98|97|96)\d{8}$/',
            ],


            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:patients,email',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],

            'gender' => [
                'nullable',
                Rule::enum(Gender::class),
            ],

            'blood_group' => [
                'nullable',
                Rule::enum(BloodGroup::class),
            ],
        ];
    }
}
