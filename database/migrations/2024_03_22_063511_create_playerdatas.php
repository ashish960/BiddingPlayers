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
        Schema::create('playerdatas', function (Blueprint $table) {
            $table->id();
            $table->string('player_name')->nullable();
            $table->string('player_no');
            $table->string('player_age')->nullable();
            $table->string('player_min_bid_price')->nullable();
            $table->string('player_current_bid_price')->nullable();
            $table->string('team_allot')->nullable();
            $table->boolean('player_status')->comment("1:Active,0:Inactive,2:Bidded")->default(0);
            $table->string('game_id');
            $table->foreign('game_id')->references('game_id')->on('gamesizings');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playerdatas');
    }
};
