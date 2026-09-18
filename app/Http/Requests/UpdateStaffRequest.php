<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Common User Fields
            |--------------------------------------------------------------------------
            */

            "name" => [
                "required",
                "string",
                "max:255",
            ],

            "email" => [
                "required",
                "email",

                Rule::unique("users", "email")
                    ->ignore($this->staff->id),
            ],

            "role" => [
                "required",
                new Enum(Role::class),

                Rule::in([
                    Role::DOCTOR->value,
                    Role::NURSE->value,
                    Role::RECEPTIONIST->value,
                ]),
            ],

            "phone" => [
                "required",
                "string",
                "max:20",
            ],

            /*
            |--------------------------------------------------------------------------
            | Department
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | Doctor Fields
            |--------------------------------------------------------------------------
            */

            "specialization" => [
                Rule::requiredIf(
                    fn () =>
                        $this->role === Role::DOCTOR->value
                ),

                "nullable",
                "string",
                "max:255",
            ],

            "license_number" => [
                Rule::requiredIf(
                    fn () =>
                        $this->role === Role::DOCTOR->value
                ),

                "nullable",
                "string",
                "max:100",

                Rule::unique(
                    "doctors",
                    "license_number"
                )->ignore(
                    $this->staff->doctor?->id
                ),
            ],
        ];
    }
}