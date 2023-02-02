<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
            
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:users', 
            'email' => 'required|string|email|confirmed|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',                
        ];
    }
    public function messages()
    {
        return[
            'name.required'=>'O nome é obrigatório.',

            'surname.required'=>'O sobrenome é obrigatório',

            'cpf.size' => 'O cpf requer 11 números, digite apenas os números.',
            'cpf.unique' => 'Este cpf já está cadastrado no nosso sistema.',
            'cpf.required' => 'O CPF é obrigatório para cadastro.',

            'password.size' => 'A senha deverá ter no mínimo 6 caracteres.',
            'password.required' => 'A senha é obrigatória, digite a senha.',
            'password.confirmed' => 'As senhas diferem, digite senhas iguais.',

            'email.unique' => 'Este email já está sendo usado no nosso sistema.',
            'email.required' => 'O email é necessário para cadastro.',
            'email.confirmed' => 'Os emails diferem, digite emails iguais.',
            'email.email' => 'Digite um formato válido de email.',
        ];
    }
}
