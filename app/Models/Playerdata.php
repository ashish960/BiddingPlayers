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
        'Player_Name',
        'Player_No',
        'Player_Age',
        'Player_MinBid_Price',
        'Player_CBidPrice_Price',
        'Player_Status'
    ];
}
