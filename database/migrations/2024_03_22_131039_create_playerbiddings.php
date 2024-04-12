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
        Schema::create('playerbiddings', function (Blueprint $table) {
            $table->id();
            $table->string('team_no')->nullable();
            $table->string('player_name')->nullable();
            $table->string('player_no');
            $table->string('team_name')->nullable();
            $table->string('bid_price')->nullable();
            $table->string('game_id');
            $table->foreign('game_id')->references('game_id')->on('gamesizings');
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
