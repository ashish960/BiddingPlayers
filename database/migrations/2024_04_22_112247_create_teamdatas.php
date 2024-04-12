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
        Schema::create('teamdatas', function (Blueprint $table) {
            $table->id();
            $table->string('team_name');
            $table->string('team_no');
            $table->string('team_password')->nullable();
            $table->string('team_size')->nullable();
            $table->string('team_current_size')->nullable();
            $table->string('team_max_bid_amount')->nullable();
            $table->string('team_current_bid_amount')->nullable();
            $table->string('team_status')->comment("1:Active,0:Inactive,2:Bidded")->default(0);
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
        Schema::dropIfExists('teamdatas');
    }
};
