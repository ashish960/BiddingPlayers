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
            $table->string('Player_Name')->nullable();
            $table->string('Player_No')->unique();
            $table->string('Player_Age')->nullable();
            $table->string('Player_MinBid_Price')->nullable();
            $table->string('Player_CBidPrice_Price')->nullable();
            $table->boolean('Player_Status')->comment("1:Active,0:Inactive,2:Bidded")->default(0);
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
