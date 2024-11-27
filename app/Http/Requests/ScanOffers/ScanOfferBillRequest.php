<?php

namespace App\Http\Requests\ScanOffers;

use Illuminate\Foundation\Http\FormRequest;

class ScanOfferBillRequest extends FormRequest
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
            'offer_id' => 'required|integer|exists:mind.offers,id',
            'total_amount' => 'required|numeric|min:1',
            'fees' => 'nullable|integer'
        ];
    }
}
