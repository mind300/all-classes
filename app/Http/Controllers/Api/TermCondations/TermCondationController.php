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
        $terms = TermCondation::get();
        return contentResponse($term);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TermCondationRequest $request)
    {
        $term = TermCondation::create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(TermCondation $term)
    {
        return contentResponse($term);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TermCondationRequest $request, TermCondation $term)
    {
        $term->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TermCondation $term)
    {
        $term->forceDelete();
        return messageResponse();
    }
}