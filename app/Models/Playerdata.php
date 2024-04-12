<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens; 
use Illuminate\Notifications\Notifiable;

class Playerdata extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'player_name',
        'player_no',
        'player_age',
        'player_min_bid_price',
        'player_current_bid_price',
        'team_allot',
        'game_id',
        'player_status'
    ];
}
