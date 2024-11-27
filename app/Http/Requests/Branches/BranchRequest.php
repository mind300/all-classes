<?php

namespace App\Http\Requests\Branches;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
        $user_id = $this->route('branch.manager_id');
        return [
            'address' => 'required|string',
            'city' => 'required|string',
            'street' => 'required|string',
            'building_number' => 'nullable|string',
            'floor_number' => 'required_with:building_number|string',
            'name' => 'required|string',
            'email' => 'required|email:filter|unique:users,email,'. $user_id,
            'mobile_number' => 'required|string|unique:profiles,mobile_number,' . $user_id,
            'job_id' => 'nullable|string',
        ];
    }
}
