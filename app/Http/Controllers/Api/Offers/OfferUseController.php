<?php

namespace App\Http\Controllers\Api\Offers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offers\OfferUseRequest;
use App\Models\Offer;
use App\Models\OfferUse;

class OfferUseController extends Controller
{
    // Scann Offer through cashier
    public function scanOffer(OfferUseRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = decrypt($data['user_id']);
        $data['offer_id'] = (new Offer)->setConnection('mind')->firstWhere('qr_code', $data['qr_code'])->id;
        $offerUse = OfferUse::create($data);
        return messageResponse();
    }
}
