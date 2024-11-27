<?php

namespace App\Http\Requests\Profiles;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $user_id = $this->route('profile.user_id');
        return [
            'name' => 'required|string',
            'email' => 'required|email:filter|unique:users,email,' . $user_id,
            'phone' => 'required|string',
            'job_id' => 'nullable|string',
        ];
    }
}
