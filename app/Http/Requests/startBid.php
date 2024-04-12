<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class startBid extends FormRequest
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
            'game_id'=>'required|integer|gt:0|exists:teamdatas,game_id',
        ];
    }
    public function messages(){
        return [
           
            'game_id.exists'=>'Invalid Game:There is not such game exists '
        ];
    }
}
