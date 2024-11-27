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
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile_number');
            $table->boolean('mobile_number_view')->default(true);
            $table->date('date_of_birth');
            $table->boolean('date_of_birth_view')->default(true);
            $table->string('location')->nullable();
            $table->boolean('location_view')->default(true);
            $table->string('job')->nullable();
            $table->boolean('job_view')->default(true);
            $table->string('bio')->nullable();
            $table->integer('following_number')->default(0);
            $table->integer('followers_number')->default(0);
            $table->integer('points')->default(0);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
