<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class setPlayerBid extends FormRequest
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
            'bid_price'=>'required|numeric|gt:0',
            'team_no'=>'required|integer|gt:0|exists:teamdatas,team_no',
            'game_id'=>'required|integer|gt:0|exists:teamdatas,game_id',
            'interest'=>'required|string|in:skip,bid'

        ];
    }
    public function messages(){
        return [
            'interest.in'=>'Interest should be either skip or purchase',
            'team_no.exists'=>'Invalid team:Given team is not Alloted',
            'game_id.exists'=>'Invalid Game:There is not such game exists with active bidding process'
        ];
    }
}
