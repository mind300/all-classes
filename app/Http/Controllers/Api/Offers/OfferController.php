<?php

namespace App\Http\Controllers\Api\Offers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offers\OfferRequest;
use App\Models\Offer;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($category = null)
    {
        $offers = $category != 'all' ? Offer::where('category', $category)->paginate(10) : Offer::paginate(10);
        return contentResponse($offers->load(['media', 'brand.media']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OfferRequest $request)
    {
        $qrCode = mt_rand(10000, 99999);
        $offer = Offer::create(array_merge($request->validated(), ['qr_code' => $qrCode]));
        if ($request->hasFile('media')) {
            $offer->addMediaFromRequest('media')->toMediaCollection('offer');
        }
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        return contentResponse($offer->load(['media', 'brand.media']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OfferRequest $request, Offer $offer)
    {
        $offer->update($request->validated());
        if ($request->hasFile('media')) {
            $offer->addMediaFromRequest('media')->toMediaCollection('offer');
        }
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        $offer->forceDelete();
        return messageResponse();
    }
}
