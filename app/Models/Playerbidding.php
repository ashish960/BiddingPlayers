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
        'Player_Name',
        'Player_No',
        'Team_Name',
        'Team_No',
        'bid_price'
    ];

}
