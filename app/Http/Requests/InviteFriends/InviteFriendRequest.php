<?php

namespace App\Http\Requests\InviteFriends;

use Illuminate\Foundation\Http\FormRequest;

class InviteFriendRequest extends FormRequest
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
            'email' => 'nullable|unique:users,email',
            'mobile_number' => 'required|unique:members,mobile_number'
        ];
    }
}
