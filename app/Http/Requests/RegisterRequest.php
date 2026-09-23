<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Enums\BloodGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | User Information
            |--------------------------------------------------------------------------
            */

            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s.\'-]+$/u',
            ],

            'middle_name' => [
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

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
                'regex:/^[A-Za-z0-9._-]+$/',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                'unique:patients,email',
            ],
            
            /*
            |--------------------------------------------------------------------------
            | Patient Information
            |--------------------------------------------------------------------------
            */

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'date_of_birth' => [
                'required',
                'date',
                'before:today',
            ],

            'gender' => [
                'required',
                new Enum(Gender::class),
            ],

            'blood_group' => [
                'nullable',
                new Enum(BloodGroup::class),
            ],

            /*
            |--------------------------------------------------------------------------
            | Password
            |--------------------------------------------------------------------------
            */

            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed',
            ],
        ];
    }
}