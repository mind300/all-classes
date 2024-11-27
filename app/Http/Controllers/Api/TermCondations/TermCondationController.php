<?php

namespace App\Http\Controllers\Api\TermCondations;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermCondations\TermCondationRequest;
use App\Models\TermCondation;
use Illuminate\Http\Request;

class TermCondationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $termsCondations = TermCondation::get();
        return contentResponse($termsCondations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TermCondationRequest $request)
    {
        $termsCondation = TermCondation::create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(TermCondation $termsCondation)
    {
        return contentResponse($termsCondation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TermCondationRequest $request, TermCondation $termsCondation)
    {
        $termsCondation->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TermCondation $termsCondation)
    {
        $termsCondation->forceDelete();
        return messageResponse();
    }
}