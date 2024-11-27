<?php

namespace App\Http\Requests\Subscriptions\Plans;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionPlanRequest extends FormRequest
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
            'name' => 'required|string',
            'frequency' => 'required|integer|in:7, 15, 30, 90, 199, 365',
            'details' => 'required|string',
            'amount_cents' => 'required|integer',
            'is_active' => 'sometimes|integer',
            'reminder_days' => 'sometimes|integer',
            'retrial_days' => 'sometimes|integer',
            'use_transaction_amount' => 'sometimes|integer',
        ];
    }
}
