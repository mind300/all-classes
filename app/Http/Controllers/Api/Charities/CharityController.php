<?php

namespace App\Http\Controllers\Api\Charities;

use App\Http\Controllers\Controller;
use App\Http\Requests\Charities\CharityRequest;
use App\Models\Charity;
use App\Models\Service;

class CharityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $charities = Charity::with(['media','services'])->paginate(10);
        return contentResponse($charities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CharityRequest $request)
    {
        $charity = Charity::create($request->validated());
        $charity->services()->createMany($request->validated('services'));
        if ($request->hasFile('media')) {
            $charity->addMediaFromRequest('media')->toMediaCollection('charity');
        }
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Charity $charity)
    {
        return contentResponse($charity->load('media','services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CharityRequest $request, Charity $charity)
    {
        // Update charity details
        $charity->update($request->validated());
        $charity->services()->upsert($request->validated('services'), ['id'], ['title']);
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Charity $charity)
    {
        $charity->forceDelete();
        return messageResponse();
    }
}
