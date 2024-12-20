<?php

namespace App\Http\Controllers\Api\Rewards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rewards\RewardRequest;
use App\Models\Reward;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rewards = Reward::with('media')->paginate(10);
        return contentResponse($rewards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RewardRequest $request)
    {
        $reward = Reward::create($request->validated());
        if ($request->hasFile('media')) {
            $reward->addMediaFromRequest('media')->toMediaCollection('reward');
        }
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Reward $reward)
    {
        return contentResponse($reward->load('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RewardRequest $request, Reward $reward)
    {
        $reward->update($request->validated());
        if ($request->hasFile('media')) {
            $reward->addMediaFromRequest('media')->toMediaCollection('reward');
        }
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reward $reward)
    {
        $reward->forceDelete();
        return messageResponse();
    }
}
