<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens; 
use Illuminate\Notifications\Notifiable;

class Gamesizing extends Model
{
    use HasApiTokens,HasFactory, Notifiable;
    protected $fillable=[
        'game_id',
        'game_name',
        'team_size',
        'player_size',
        'team_max_bid_amount'

    ];
}
