<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addPlayer extends FormRequest
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
            'player_name'=>'required|string',
            'player_no'=>'required|integer|gt:0',
            'player_age'=>'required|integer|gt:0',
            'player_min_bid_price'=>'required|numeric|gt:0',
            'game_id'=>'bail|required|numeric|gt:0|exists:gamesizings,game_id'      //here bail exits the validation check if any of validation fails.
        ];
    }
    public function messages(){
        return [
            'game_id.exists'=>'The given game not exists'
        ];
    }
}
