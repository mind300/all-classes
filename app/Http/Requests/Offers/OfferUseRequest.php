<?php

namespace App\Http\Requests\Offers;

use Illuminate\Foundation\Http\FormRequest;

class OfferUseRequest extends FormRequest
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
            'offer_id' => 'required|exists:mind.offers,id',
            'qr_code' => 'required|integer|exists:mind.offers,qr_code',
            'user_id' => 'required|integer',
            'community_name' => 'required|string'
        ];
    }
}
