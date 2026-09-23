<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Role;
use Illuminate\Validation\Rule;

class StoreStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            // Common user fields
            "name" => [
                "required",
                "string",
                "max:255",
                'regex:/^[\pL\s.\'-]+$/u',
            ],

            "username" => [
                "required",
                "string",
                "max:255",
                'regex:/^[A-Za-z0-9._-]+$/',
                "unique:users,username",
            ],

            "employee_id" => [
                "required",
                "string",
                "max:255",
                "unique:users,employee_id",
            ],

            "email" => [
                "required",
                "email",
                "unique:users,email",
            ],

            "role" => [
                "required",
                new Enum(Role::class),
            ],

            // Common staff profile field
            "phone" => [
                "required",
                "string",
                "max:20",
            ],

            // Required for Doctor and Nurse
            "department_id" => [
                Rule::requiredIf(
                    fn () =>
                        in_array($this->role, [
                            Role::DOCTOR->value,
                            Role::NURSE->value,
                        ])
                ),
                "nullable",
                "exists:departments,id",
            ],

            // Doctor only
            "specialization" => [
                Rule::requiredIf(fn () => $this->role === Role::DOCTOR->value),
                "nullable",
                "string",
                "max:255",
            ],

            "license_number" => [
                Rule::requiredIf(fn () => $this->role === Role::DOCTOR->value),
                "nullable",
                "string",
                "max:100",
                "unique:doctors,license_number",
            ],
        ];
    }
}
