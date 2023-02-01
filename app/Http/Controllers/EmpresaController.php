<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpresaController extends Controller
{
    private $empresa;
    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function vender(Request $request){
        
        //Empresa::where('cnpj_empresa', '=', auth()->user()->cnpj)->increment('saldo', $request->valor);
             
        Empresa::where('cnpj', '=', Auth::guard('empresa')->user()->cnpj)->increment('saldo_empresa', $request->valor);//temporário
        return view('empresa.dashboard');
    } 
    public function adicionarAdmin(){
        return redirect()->route('register');
    }
}
