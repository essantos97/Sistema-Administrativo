<?php

namespace App\Http\Controllers\AuthEmpresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
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
    public function store(EmpresaRequest $request)
    {        

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
