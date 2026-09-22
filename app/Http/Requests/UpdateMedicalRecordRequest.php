<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $medicalRecord = $this->route('medicalRecord');

        return $this->user()->can(
            'update',
            $medicalRecord
        );
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'record_date' => 'sometimes|required|date',

            'chief_complaint' => 'nullable|string|max:1000',
            'symptoms' => 'nullable|string|max:2000',
            'diagnosis' => 'nullable|string|max:2000',
            'examination' => 'nullable|string|max:2000',
            'treatment' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:2000',
        ];
    }
}
