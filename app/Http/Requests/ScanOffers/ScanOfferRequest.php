<?php

namespace App\Http\Requests\ScanOffers;

use Illuminate\Foundation\Http\FormRequest;

class ScanOfferRequest extends FormRequest
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
            'qr_code' => 'required|integer|exists:mind.offers,qr_code',
            'user_email' => 'required|email:filter',
            'community_name' => 'required|string',
            'offer_id' => 'required|integer|exists:mind.offers,id',
        ];
    }
}
