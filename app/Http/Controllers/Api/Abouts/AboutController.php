<?php

namespace App\Http\Controllers\Api\Abouts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Abouts\AboutRequest;
use App\Models\About;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = About::get();
        return contentResponse($abouts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutRequest $request)
    {
        $about = About::create($request->validated());
        if ($request->hasFile('media')) {
            $about->addMediaFromRequest('media')->toMediaCollection('about');
        }
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(About $about)
    {
        return contentResponse($about);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AboutRequest $request, About $about)
    {
        $about->update($request->validated());
        if ($request->hasFile('media')) {
            $about->addMediaFromRequest('media')->toMediaCollection('about');
        }
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {
        $about->forceDelete();
        return messageResponse();
    }
}
