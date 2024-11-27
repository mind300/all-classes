<?php

namespace App\Http\Controllers\Api\Subscriptions\Users;

use App\Http\Controllers\Api\Paymob\SubscriptionController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriptions\Users\SubscriptionUserRequest;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionUser;

class SubscriptionUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = SubscriptionUser::where('user_id', auth_user_id())->with('transactions')->get();
        return contentResponse($subscriptions);
    }


    /**
     * Display a listing of the resource.
     */
    public function plans()
    {
        $subscription_plans = (new SubscriptionPlan)->setConnection('mind')->where('is_active', 1)->get();
        return contentResponse($subscription_plans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionUserRequest $request)
    {
        $intention = SubscriptionController::intention($request->validated());
        if (!$intention) return messageResponse('Error occured', false, 403);
        $pay_url = "https://accept.paymob.com/unifiedcheckout/?publicKey=" . env('PAYMOB_PUBLIC_KEY') . "&clientSecret=" . $intention['client_secret'];
        return response()->json(['pay_url' => $pay_url]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionUser $user)
    {
        return contentResponse($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionUserRequest $request, SubscriptionUser $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionUser $user)
    {
        //
    }
}
