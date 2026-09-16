<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:35'],
            'email' => ['required', 'string' ,'email', 'unique:users', 'max:255'],
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return[
            'name.required' => "The name field is required, please enter your name",
            'name.string' => "Name can only be composed of string characters",
            'name.max' => "Maximum number of characters for name is 35, try again with less characters",
            'email.email' => "Enter a valid email",
            'email.max' => "Maximum number of characters for email is 255.",
            'email.required' => "Email field is required, please enter your email.",
            'email.unique' => "Email is already in use, try with another email.",
            'password.min' => "Minimum number of characters for password is 8.",
            'password.required' => "Password field is necessary to login.",
            'password.confirmed' => "The password confirmation does not match the password you entered",
        ];
    }
}
