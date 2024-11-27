<?php

namespace App\Http\Requests\Cashires;

use Illuminate\Foundation\Http\FormRequest;

class CashierRequest extends FormRequest
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
        $user_id = $this->route('cashier.user_id');
        return [
            'name' => 'required|string',
            'email' =>  'required|email:filter|unique:users,email,' . $user_id,
            'mobile_number' =>  'required|unique:profiles,mobile_number,' . $user_id,
            'job_id' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id'
        ];
    }
}
