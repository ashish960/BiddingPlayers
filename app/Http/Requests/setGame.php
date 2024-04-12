<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator; 

class setGame extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [
               'game_id'=>'required|integer|unique:gamesizings,game_id|gt:0',
               'game_name'=>'required|string',
               'team_size'=>'required|integer|gt:2',
               'player_size'=>'required|integer|gt:1',
               'team_max_bid_amount'=>'required|numeric|gt:0|'
        ];
    }

  
}
