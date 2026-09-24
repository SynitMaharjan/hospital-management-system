<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCheckInRequest extends FormRequest
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
        $today = now()->toDateString();

        return [
            'appointment_id' => [
                'required',
                'integer',
                Rule::exists('appointments', 'id')->where(function ($query) use ($today) {
                    $query->whereDate('appointment_date', $today)
                          ->where('status', 'confirmed');
                }),
            ],
        ];
    }
}
