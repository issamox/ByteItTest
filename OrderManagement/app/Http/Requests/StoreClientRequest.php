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
            'phone' => 'required|regex:/^(\+?[0-9]{1,4})?\(?\d{1,4}\)?[\d\-\s]+$/', // Simple phone number regex (adjust as needed)
            'address' => 'required|string|max:500',

        ];
    }
}
