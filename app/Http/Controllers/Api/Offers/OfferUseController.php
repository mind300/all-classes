<?php

namespace App\Http\Controllers\Offers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offers\OfferUseRequest;
use App\Models\OfferUse;

class OfferUseController extends Controller
{
    // Scann Offer through cashier
    public function scanOffer(OfferUseRequest $request)
    {
        $offerUse = OfferUse::create($request->validated());
        return messageResponse();
    }
}
