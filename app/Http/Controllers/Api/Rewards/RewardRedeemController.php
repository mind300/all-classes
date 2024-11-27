<?php

namespace App\Http\Controllers\Api\Rewards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rewards\RewardRedeemRequest;
use App\Models\RewardRedeem;

class RewardRedeemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rewardsRedeem = RewardRedeem::with('reward')->where('user_id', auth_user_id())->get();
        return contentResponse($rewardsRedeem);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RewardRedeemRequest $request)
    {
        $rewardsRedeem = RewardRedeem::create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(RewardRedeem $redeem)
    {
        return contentResponse($redeem->load('reward'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RewardRedeemRequest $request, RewardRedeem $redeem)
    {
        $redeem->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RewardRedeem $redeem)
    {
        $redeem->forceDelete();
        return messageResponse();
    }
}
