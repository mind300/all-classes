<?php

namespace App\Http\Requests\Jobs;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'title' => 'required|string',
            'type' => 'required|string',
            'location' => 'nullable|string',
            'salary_range' => 'required|numeric',
            'user_experience' => 'required|string',
            'how_to_apply' => 'nullable|string',
            'description' => 'required|string',
        ];
    }
}
