<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriarContaRequest extends FormRequest
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
           
            'num_conta'=>'required|integer|unique:contas|max:999999999999999',
            'proprietario'=>'required|string:255',                
             
        ];
    }
    public function messages()
    {
        return [

            'num_conta.required'=>'O número da conta é obrigatório.',  
            'num_conta.unique'=>'Esta conta já está no sistema.',          
            'num_conta.integer'=>'O número da conta é totalmente numérico.',
            'num_conta.max'=>'O número da conta deve ter no máximo 15 numeros.',

            'proprietario.required'=>'O nome do proprietário da conta é obrigatório',             
        ];
    }
}
