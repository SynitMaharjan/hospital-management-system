<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Gender;

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

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
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

