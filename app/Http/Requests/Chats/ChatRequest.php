<?php

namespace App\Http\Requests\Chats;

use Illuminate\Foundation\Http\FormRequest;

  class ChatRequest extends FormRequest
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
            'type' => 'required|string|in:personal,group',
            'name' => 'nullable|string',
            'created_by' => 'nullable|integer|exists:users,id',
            'members' => 'required|array',
            'members.*.member_id' => 'required|integer|exists:members,id'
        ];
    }
}
