<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\User;
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
        return view('auth.register');
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
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:users', 
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ],
        ['name'=>'O nome é obrigatório',

        'surname'=>'O sobrenome é obrigatório',

        'cpf.size' => 'O cpf requer 11 números, digite apenas os números',
        'cpf.unique' => 'Este cpf já está cadastrado no nosso sistema',
        'cpf.required' => 'O CPF é obrigatório para cadastro',

        'password.size' => 'A senha deverá ter no mínimo 8 caracteres',

        'email.unique' => 'Este email já está sendo usado no nosso sistema',
        'email.required' => 'O email é necessário para cadastro',]);

       if (null==Empresa::where('email', '=', $request->email)->first()) {
            $user = User::create([            
                'name' => $request->name,
                'surname' => $request->surname,
                'cpf' => $request->cpf,            
                'cnpj_empresa' => Auth::guard('empresa')->user()->cnpj,                
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'permissao' => 'admin',
            ]);
            Empresa::where('cnpj', '=', Auth::guard('empresa')->user()->cnpj)->update(['cpf_admin' => $request->cpf]);
        }
        

        return redirect(RouteServiceProvider::EMPRESA_HOME);
    }
}
