<?php

namespace App\Http\Controllers\Api\Offers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offers\OfferUseRequest;
use App\Models\Offer;
use App\Models\OfferUse;
use App\Models\User;

class OfferUseController extends Controller
{
    // Scann Offer through cashier
    public function scanOffer(OfferUseRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = decrypt($data['user_id']);
        $data['offer_id'] = (new Offer)->setConnection('mind')->firstWhere('qr_code', $data['qr_code'])->id;
        $user = User::find($data['user_id']);
        if (!$user) return messageResponse('User not found', false, 404);
        $offerUse = OfferUse::create($data);
        return messageResponse();
    }
}
