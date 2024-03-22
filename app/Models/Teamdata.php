<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens; 
use Illuminate\Notifications\Notifiable;

class Teamdata extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'team_name',
        'team_id',
        'team_passkey',
        'team_current_size',
        'max_bid_size',
        'team_bid_size',
        'team_status'
    ];
}
