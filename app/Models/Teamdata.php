<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens; 
use Illuminate\Notifications\Notifiable;


use Illuminate\Foundation\Auth\Teamdata as Authenticatable;

class Teamdata extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'team_name',
        'team_no',
        'team_password',
        'team_size',
        'team_current_size',
        'team_max_bid_size',
        'team_max_bid_amount',
        'team_current_bid_amount',
        'team_status',
        'game_id'
    ];

    protected $hidden = [
        
        'remember_token',
    ];
}
