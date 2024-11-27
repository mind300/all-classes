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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('frequency', [7, 15, 30, 90, 199, 365])->default(30);
            $table->longText('details');
            $table->integer('amount_cents')->default(0);
            $table->string('is_active')->default(true);
            $table->integer('reminder_days')->default(2);
            $table->integer('retrial_days')->default(10);
            $table->integer('use_transaction_amount')->default(false);
            $table->unsignedBigInteger('paymob_sub_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
