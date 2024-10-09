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
    public function index()
    {
        $offers = Offer::get();
        return contentResponse($offers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OfferRequest $request)
    {
        $offer = Offer::create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        return contentResponse($offer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OfferRequest $request, Offer $offer)
    {
        $offer->update($request->validated());
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
