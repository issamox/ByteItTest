<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email|max:255',
            'phone' => ['required', 'regex:/^(06|07)[0-9]{8}$/'], // Validates 10 digits starting with 06 or 07
            'address' => 'required|string|max:500',

        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'The phone number must start with 06 or 07 and be exactly 10 digits.',
        ];
    }
}
