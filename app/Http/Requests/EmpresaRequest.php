<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
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
            'cnpj' => 'required|string|size:14|unique:empresas',
            'razao' => 'required|string|max:255',
            'nomeFantasia' => 'required|string|max:255',
            'telefone' => 'required|string|min:10|max:11',            
            'email' => 'required|string|email|max:255|unique:empresas',
            'password' => 'required|string|confirmed|min:6',            
        ];
    }
    public function messages()
    {
        return[
            'cnpj.required'=>'CNPJ é obrigatório.',
            'cnpj.unique'=>'Este CNPJ já está cadastrado no nosso sistema.',
            'cnpj.size'=>'O CNPJ é composto por 14 números.',
    
            'razao.required'=>'É necessário informar a razão social.',
    
            'nomeFantasia.required'=>'O nome fantasia é obrigatório',
    
            'telefone.required'=>'O telefone é obrigatório.',
            'telefone.max'=>'O telefone está com digitos demais.',
            'telefone.min'=>'Digite um telefone válido com ddd.',
    
            'email.required'=>'O email é obrigatório, digite o email',
            'email.email'=>'Digite o email no formato correto.',
            'email.unique'=>'Esse email já está cadastrado no sistema.',
                
            'password.required'=>'A senha é obrigatória',
            'password.confirmed'=>'As senhas estão diferentes',
            'password.min'=>'É necessário ter pelo menos 6 caracteres.',
        ];   
    }
}
