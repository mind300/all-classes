<?php

namespace App\Http\Requests\PointSystems;

use Illuminate\Foundation\Http\FormRequest;

class PointSystemRequest extends FormRequest
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
            'action' => 'required|string',
            'display_name' => 'required|string',
            'points' => 'required|integer',
            'active' => 'nullable|integer',
        ];
    }
}
