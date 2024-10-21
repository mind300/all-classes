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
        $user_id = $this->route('cashier');
        return [
            'name' => 'required|string',
            'email' =>  'required|email:filter|unique:suppliers.users,email,' . $user_id,
            'password' => 'nullable|string|min:8',
            'brand_id' => 'required|exists:brands,id'
        ];
    }
}
