<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use App\Models\Empresa;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
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
     * @param  \Illuminate\Http\UsuarioRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UsuarioRequest $request)
    {     
        try {
            
            // verificação para confirmar se existe email igual no sistema
            if (null == Empresa::where('email', '=', $request->email)->first()) {
                try {
                    if (null == User::where('cnpj_empresa', '=', Auth::guard('empresa')->user()->cnpj)->first()) {
                        User::create([            
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
                     else {
                        throw new Exception("Você já cadastrou um administrador.", 3);
                    }
                    
                } catch (Exception $e) {                    
                    return back()->with('msg', $e->getMessage());
                }
                                  
            }else{
                throw new Exception("Este email já está cadastrado no sistema, em uma conta empresarial.", 2);
            }
        } catch (Exception $e) {                                                                                                                    
            return back()->with('msg', $e->getMessage());
        }             
        
    }
}
