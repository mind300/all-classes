<?php

namespace App\Models;

class ScanOffer extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'community_name',
        'total_amount',
        'total_before',
        'total_after',
        'fees',
        'user_name',
        'user_email',
        'offer_id',
    ];
    // ====================== Relations For Mind =================== //
    // Each scan offer belongs to offer
    public function offer()
    {
        return $this->setConnection('mind')->belongsTo(Offer::class, 'offer_id');
    }

    // ====================== Observe =================== //
    protected static function booted()
    {
        static::updating(function ($model) {
            $model->total_before =  $model->total_amount;
            $model->total_after = $model->total_before * $model->offer->discount / 100;
            $model->total_amount = $model->total_after + $model->fees;
        });
    }
}
