<?php

namespace App\Http\Requests\BuySell;

use Illuminate\Foundation\Http\FormRequest;

class BuySellRequest extends FormRequest
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
            // 'media' => 'required|image',
            'title' => 'required|string',
            'price_before' => 'required|numeric',
            'price_after' => 'required|numeric',
            'description' => 'required|string',
        ];
    }
}
