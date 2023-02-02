<?php

namespace App\Http\Controllers\AuthEmpresa;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Empresa;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('empresa.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'cnpj' => 'required|string|size:14|unique:empresas',
            'razao' => 'required|string|max:255',
            'nomeFantasia' => 'required|string|max:255',
            'telefone' => 'required|string|min:10|max:11',            
            'email' => 'required|string|email|max:255|unique:empresas',
            'password' => 'required|string|confirmed|min:6',
        ],[
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
        ]);

        if (null==User::where('email', '=', $request->email)->first()) {
            $user = Empresa::create([            
                'cnpj' => $request->cnpj,
                'cpf_admin' => null,
                'saldo_empresa' => 0,
                'razao' => $request->razao,
                'nomeFantasia' => $request->nomeFantasia,
                'telefone' => $request->telefone,
                'email' => $request->email,
                'permissao' => 'usuario',
                'password' => Hash::make($request->password),
            ]);
    
            event(new Registered($user));
    
            Auth::guard('empresa')->login($user);
            return redirect(RouteServiceProvider::EMPRESA_HOME);
        }
        
        return back()->withInput();
    }
}
