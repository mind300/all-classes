<?php

namespace App\Http\Requests\Rewards;

use Illuminate\Foundation\Http\FormRequest;

class RewardRequest extends FormRequest
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
            'quantity' => 'required|integer',
            'redeem_points' => 'required|integer',
            'description' => 'required|string',
            'status' => 'nullable|string|in:active,inactive,sold_out'
        ];
    }
}
