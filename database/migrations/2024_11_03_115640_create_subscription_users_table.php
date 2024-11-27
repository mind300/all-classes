<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedBigInteger('paymob_sub_id');
            $table->string('plan_name');
            $table->integer('amount_cents');
            $table->date('starts_at');
            $table->date('next_billing');
            $table->date('reminder_date');
            $table->string('hmac');
            $table->string('transaction_id');
            $table->string('card_token')->nullable();
            $table->string('masked_pan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_users');
    }
};
