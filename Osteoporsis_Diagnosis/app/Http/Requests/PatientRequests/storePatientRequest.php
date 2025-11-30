<?php

namespace App\Http\Requests\PatientRequests;

use Illuminate\Foundation\Http\FormRequest;

class storePatientRequest extends FormRequest
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
            // Patient
            'doctor_id'     => 'required|exists:users,id',
            'first_name'    => 'required|string|max:255',
            'father_name'   => 'nullable|string|max:255',
            'last_name'     => 'required|string|max:255',
            'gender'        => 'nullable|in:male,female',
            'age'           => 'nullable|integer',
            'menopause_age' => 'nullable|integer',
            'height_m'      => 'nullable|numeric',
            'weight_kg'     => 'nullable|numeric',
            'bmi'           => 'nullable|numeric',
            'occupation'    => 'nullable|string|max:255',
            'phone_number'  => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:255',

            'medical_history' => 'nullable|array',
            'medical_history.joint_pain' => 'boolean',
            'medical_history.smoker' => 'boolean',
            'medical_history.alcoholic' => 'boolean',
            'medical_history.diabetic' => 'boolean',
            'medical_history.hypothyroidism' => 'boolean',
            'medical_history.seizure_disorder' => 'boolean',
            'medical_history.estrogen_use' => 'boolean',
            'medical_history.history_of_fracture' => 'boolean',
            'medical_history.dialysis' => 'boolean',
            'medical_history.family_history_osteoporosis' => 'boolean',
            'medical_history.number_of_pregnancies' => 'nullable|integer',
            'medical_history.maximum_walking_distance' => 'nullable|string',
            'medical_history.daily_eating_habits' => 'nullable|string',
            'medical_history.obesity' => 'boolean',
            'medical_history.notes' => 'nullable|string',

            'medications' => 'nullable|array',
            'medications.*.medication_name' => 'required|string|max:255',
            'medications.*.dosage' => 'nullable|string|max:255',
            'medications.*.frequency' => 'nullable|string|max:255',
            'medications.*.notes' => 'nullable|string',

            'radiology.original_image_path' => 'required|string',
            'radiology.site' => 'nullable|string|max:255',
        ];
    }
}
