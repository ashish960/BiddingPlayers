<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens; 
use Illuminate\Notifications\Notifiable;

class Playerbidding extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
}
