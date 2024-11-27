<?php

namespace App\Models;

class Transaction extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'paymob_trans_id',
        'amount_cents',
        'currency',
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'card_number',
        'card_type',
        'masked_pan',
        'subscription_plan_id',
        'success',
    ];

    // ====================== Relations For Mind =================== //
    // Each transaction belong to subscripton plan
    public function subscription_plans()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }
}
