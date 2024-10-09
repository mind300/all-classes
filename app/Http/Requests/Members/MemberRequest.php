<?php

namespace App\Http\Requests\Members;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
        $user_id = $this->route('user.id');
        return [
            'email' => $user_id ? 'required|email|unique:users,email,' . $user_id : 'nullable',
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'mobile_number' => 'required|string',
            'date_of_birth' => 'required|date',
            'location' => 'sometimes|string'
        ];
    }
}
