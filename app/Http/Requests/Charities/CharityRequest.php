<?php

namespace App\Http\Requests\Charities;

use Illuminate\Foundation\Http\FormRequest;

class CharityRequest extends FormRequest
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
            'media' => 'nullable|image',
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'website' => 'required|string',
            'email' => 'required|string',
            'description' => 'required|string',
            'services' => 'required|array',
            'services.*.id' => 'nullable|integer',
            'services.*.title' => 'required|string',
            'services.*.description' => 'required|string',
        ];
    }
}
