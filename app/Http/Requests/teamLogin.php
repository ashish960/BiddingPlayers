<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class teamLogin extends FormRequest
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
            'team_no'=>'required|integer|exists:teamdatas,team_no|gt:0',
            'game_id'=>'required|integer|gt:0|exists:gamesizings,game_no',
            'team_password'=>'required|min:8'
        ];
    }
    public function messages(){
        return [
        
            'game_id.exists'=>'Invalid Game:There is no such team alloted with given game '
        ];
    }
}
