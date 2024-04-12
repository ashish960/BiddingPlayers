<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addTeam extends FormRequest
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
            'team_name'=>'required|string',
            'team_no'=>'required|integer|gt:0',
            'team_password'=>'required|string|min:8',
            'team_size'=>'required|integer|gt:0',
            'team_max_bid_amount'=>'required|numeric|gt:0',
            'game_id'=>'required|integer|gt:0|exists:gamesizings,game_id'
            
        ];
    }
    public function messages(){
        return [
            'game_id.exists'=>'The given game not exists'
        ];
    }
}
