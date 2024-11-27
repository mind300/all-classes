<?php

namespace App\Models;

class SubscriptionUser extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'paymob_sub_id',
        'plan_name',
        'amount_cents',
        'starts_at',
        'next_billing',
        'reminder_date',
        'hmac',
        'transaction_id',
        'card_token',
        'card_type',
        'card_number',
        'masked_pan',
    ];

    // ====================== Relations For Communtiy=================== //
    // Each subscription belongs to transaction
    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'subscription_plan_id');
    }
}
