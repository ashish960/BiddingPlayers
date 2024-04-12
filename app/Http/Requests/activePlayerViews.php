<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class activePlayerViews extends FormRequest
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
            'game_id'=>'required|integer|gt:0|exists:playerdatas,game_id',
            'team_no'=> 'required|integer|gt:0|exists:teamdatas,team_no'
        ];
    }
    public function messages(){
        return [
            
            'player_game_id.exists'=>'Invalid Game:There is no such game exists',
            'team_no.exists'=>'Invalid Team :There is no such game exists'
        ];
    }
}
