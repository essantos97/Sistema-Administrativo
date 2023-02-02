<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaqueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [                   
            'num_conta' => 'required|integer|max:999999999999999',
            'valor' => 'required|integer',                                                  
        ];
    }
    public function messages()
    {
        return [
            'num_conta.required'=>'O número da conta é obrigatório.',
            'num_conta.integer'=>'O número da conta é totalmente numérico.',
            'num_conta.max'=>'O número da conta deve ter no máximo 15 numeros.',  

            'valor.required'=>'O valor do saque é obrigatório.',
            'valor.integer'=>'O valor deve ser numérico.',   
        ];
    }
}
