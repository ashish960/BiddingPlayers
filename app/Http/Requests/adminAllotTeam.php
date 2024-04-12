<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class adminAllotTeam extends FormRequest
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
            'game_id'=>'required|integer|gt:0|exists:gamesizings,game_id',
            'player_no'=>'required|integer|gt:0|exists:playerdatas,player_no'
        ];
    }
    public function messages(){
        return [
            'player_no.exists'=>'Invalid player:Given game has no such player Alloted',
            'game_id.exists'=>'Invalid Game:There is no such game exists with active bidding process'
        ];
    }
}
