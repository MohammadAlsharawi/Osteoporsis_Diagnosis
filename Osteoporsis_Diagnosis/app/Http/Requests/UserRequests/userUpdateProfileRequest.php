<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;

class userUpdateProfileRequest extends FormRequest
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
            'name'       => 'nullable|string|max:255',
            'email'      => 'nullable|email|unique:users',
            'password'   => 'nullable|string|min:6|confirmed',
            'nationality' => 'nullable|string|max:100',
            'phone_number' => 'nullable|string|max:20',
            'birthdate'  => 'nullable|date',
            'address'    => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:100',
            'father_name'=> 'nullable|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'gender'     => 'nullable|in:male,female',
            'medical_specialty' => 'nullable|string|max:255',
        ];
    }
}
