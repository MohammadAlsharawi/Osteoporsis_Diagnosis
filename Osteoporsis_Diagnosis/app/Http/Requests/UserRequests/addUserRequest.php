<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;

class addUserRequest extends FormRequest
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
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|string|min:6|confirmed',
            'nationality' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'birthdate'  => 'required|date',
            'address'    => 'required|string|max:255',
            'first_name' => 'required|string|max:100',
            'father_name'=> 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'gender'     => 'required|in:male,female',
            'medical_specialty' => 'required|string|max:255',
        ];
    }
}
