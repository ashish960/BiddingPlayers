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
        Schema::create('playerbidding', function (Blueprint $table) {
            $table->id();
            $table->string('Player_Name')->nullable();
            $table->string('Player_No')->unique();
            $table->string('Team_Name')->nullable();
            $table->string('Team_No')->nullable();
            $table->string('bid_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playerbidding');
    }
};
