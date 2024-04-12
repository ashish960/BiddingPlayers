<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens; 
use Illuminate\Notifications\Notifiable;

class Playerbidding extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'game_id',
        'player_name',
        'player_no',
        'team_name',
        'team_no',
        'bid_price'
    ];

}
