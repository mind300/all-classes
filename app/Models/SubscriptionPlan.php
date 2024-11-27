<?php

namespace App\Models;

class SubscriptionPlan extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'frequency',
        'details',
        'amount_cents',
        'is_active',
        'reminder_days',
        'retrial_days',
        'use_transaction_amount',
        'paymob_sub_id'
    ];
}
