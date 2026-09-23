<?php

namespace App\Http\Requests;

use App\Enums\BloodGroup;
use App\Enums\Gender;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
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
            
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s.\'-]+$/u',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('patients', 'email')
                    ->ignore($this->route('patient')->id),
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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with(
                    'edit_patient_id',
                    $this->route('patient')->id
                )
        );
    }
}