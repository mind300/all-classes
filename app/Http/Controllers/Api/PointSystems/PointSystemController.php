<?php

namespace App\Http\Controllers\Api\PointSystems;

use App\Http\Controllers\Controller;
use App\Http\Requests\PointSystems\PointSystemRequest;
use App\Models\PointSystem;

class PointSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $systems = PointSystem::get();
        return contentResponse($systems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PointSystemRequest $request)
    {
        $action = PointSystem::create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(PointSystem $system)
    {
        return contentResponse($system);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PointSystemRequest $request, PointSystem $system)
    {
        $system->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PointSystem $system)
    {
        $system->forceDelete();
        return messageResponse();
    }
}
