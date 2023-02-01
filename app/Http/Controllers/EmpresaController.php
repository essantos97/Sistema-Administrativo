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

    /**
     * Método responsável por realizar uma venda e adicionar esse valor ao saldo da empresa,
     *  e verificar se os dados da request são válidos para a operação.
     * 
     * @param  Illuminate\Http\Request;  $request
     * @return \Illuminate\View\View
     */

    public function vender(Request $request){
                   
        $request->validate([            
            'valor' => 'required',            
        ]);
        Empresa::where('cnpj', '=', Auth::guard('empresa')->user()->cnpj)->increment('saldo_empresa', $request->valor);//temporário
        return view('empresa.dashboard');
    } 
    /**
     * Método responsável por adicionar uma administrador, faz apenas o redirecionamento
     * para a página de registro.
     * @param  
     * @return 
     */
    public function adicionarAdmin(){
        return redirect()->route('register');
    }
}
