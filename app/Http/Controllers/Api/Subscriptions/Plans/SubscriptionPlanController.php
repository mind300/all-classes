<?php

namespace App\Http\Controllers\Api\Subscriptions\Plans;
// Controllers
use App\Http\Controllers\Api\Paymob\SubscriptionController;
use App\Http\Controllers\Controller;
// Models
use App\Models\SubscriptionPlan;
// Request
use App\Http\Requests\Subscriptions\Plans\StoreSubscriptionPlanRequest;
use App\Http\Requests\Subscriptions\Plans\UpdateSubscriptionPlanRequest;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = SubscriptionPlan::get();
        return contentResponse($subscriptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionPlanRequest $request)
    {
        $paymob_subscription = SubscriptionController::createSubscriptionPlan(array_merge($request->validated(), ['webhook_url' => env('PAYMOB_WEBHOOK_URL'), 'integration' => env('PAYMOB_INTEGRATION_ID')]));
        if (!$paymob_subscription->successful()) return messageResponse($paymob_subscription->json('message') ?? 'Error occured', false, 403);
        $subscription = SubscriptionPlan::create(array_merge($request->validated(), ['paymob_sub_id' => $paymob_subscription['id']]));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionPlan $plan)
    {
        return contentResponse($plan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionPlanRequest $request, SubscriptionPlan $plan)
    {
        $paymob_subscription = SubscriptionController::updateSubscriptionPlan(array_merge($request->validated(), ['subscription_plan_id' => $plan->paymob_sub_id]));
        if (!$paymob_subscription->successful()) return messageResponse($paymob_subscription->json('message') ?? 'Error occured', false, 403);
        $plan->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $subscription)
    {
        $subscription->forceDelete();
        return messageResponse();
    }

    /**
     * Suspend the specified resource from storage.
     */
    public function suspend(SubscriptionPlan $plan)
    {
        $paymob_subscription = SubscriptionController::suspendSubscriptionPlan($plan->paymob_sub_id);
        if (!$paymob_subscription->successful()) return messageResponse($paymob_subscription->json('message') ?? 'Error occured', false, 403);
        $plan->update(['is_active' => false]);
        return messageResponse();
    }

    /**
     * resume the specified resource from storage.
     */
    public function resume(SubscriptionPlan $plan)
    {
        $paymob_subscription = SubscriptionController::resumeSubscriptionPlan($plan->paymob_sub_id);
        if (!$paymob_subscription->successful()) return messageResponse($paymob_subscription->json('message') ?? 'Error occured', false, 403);
        $plan->update(['is_active' => true]);
        return messageResponse();
    }
}
