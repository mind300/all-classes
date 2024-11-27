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
        Schema::create('scan_offers', function (Blueprint $table) {
            $table->id();
            $table->string('community_name')->nullable();
            $table->double('total_amount')->default(0);
            $table->double('total_before')->default(0);
            $table->double('total_after')->default(0);
            $table->integer('fees')->default(0);
            $table->string('user_name');
            $table->string('user_email');
            $table->unsignedBigInteger('offer_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_offers');
    }
};
