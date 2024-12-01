<?php

namespace App\Http\Requests\Offers;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            'category' => 'required|string',
            'brand_info' => 'required|string',
            'title' => 'required|string',
            'discount' => 'required|integer',
            'description' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
        ];
    }
}
