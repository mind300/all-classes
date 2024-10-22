<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offer_uses', function (Blueprint $table) {
            $table->id();
            $table->string('community_name')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedBigInteger('offer_id');
            $table->timestamps();
        });

        // DB::statement('ALTER TABLE community_1.offer_uses ADD CONSTRAINT fk_offer_id FOREIGN KEY (offer_id) REFERENCES mind.offers(id) ON DELETE CASCADE');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::statement('ALTER TABLE community_1.offer_uses DROP FOREIGN KEY fk_offer_id');
        Schema::connection('community_1')->dropIfExists('offer_uses');
    }
};
