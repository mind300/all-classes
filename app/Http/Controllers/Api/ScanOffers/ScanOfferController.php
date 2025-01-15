<?php

namespace App\Http\Controllers\Api\ScanOffers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScanOffers\ScanOfferBillRequest;
use App\Http\Requests\ScanOffers\ScanOfferRequest;
use App\Models\ScanOffer;
use App\Models\User;
use Illuminate\Support\Facades\Config;

class ScanOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $connection = Config::get('database.default');
        $scanOffers = $connection == 'suppliers' ? ScanOffer::get() : (new ScanOffer)->setConnection('suppliers')->where([
            'user_email' => auth_user()->email,
            'community_name' => Config::get('database.default'),
        ])->get();
        return contentResponse($scanOffers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScanOfferRequest $request)
    {
        $user = (new User)->setConnection($request->validated('community_name'))->firstWhere('email', $request->validated('user_email'));
        $scanOffer = ScanOffer::create(array_merge($request->validated(), ['user_name' => $user->name, 'user_email' => $user->email]));
        point_system('redeem_offer', false, $user->id, $request->validated('community_name'));
        return contentResponse(['scan_offer_id', $scanOffer]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ScanOffer $offer)
    {
        return contentResponse($offer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScanOfferBillRequest $request, ScanOffer $offer)
    {
        $offer->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScanOffer $offer)
    {
        $offer->forceDelete();
        return messageResponse();
    }
}
