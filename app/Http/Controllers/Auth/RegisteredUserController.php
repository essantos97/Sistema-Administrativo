<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
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
    public function store(UsuarioRequest $request)
    {            
        // verificação para confirmar se existe email igual no sistema
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

            return redirect(RouteServiceProvider::EMPRESA_HOME);
        }

        return back()->withInput();
        
    }
}
