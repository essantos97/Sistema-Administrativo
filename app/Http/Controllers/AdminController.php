<?php

namespace App\Http\Controllers;

use App\Jobs\Pagamento;
use App\Models\Conta;
use App\Models\Empresa;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\all;

class AdminController extends Controller
{
    private $usuario;
    public function __construct(User $usuario)
    {
        $this->usuario = $usuario;
    }
   /**
     * Método responsável por verificar se os dados mínimos e obrigatórios para o saque(pagamento)
     * estão corretos e fazer as verificações necessárias para criar o job de saque que fará a 
     * transação no sistema.
     *
     * @param  Illuminate\Http\Request;  $request
     * @return App\Providers\RouteServiceProvider
     * @return \Illuminate\View\View
     */
    public function saque(Request $request){        
        
        $request->validate([
            'num_conta' => 'required|max:15',
            'valor' => 'required',            
        ]);
        
        //Verificações mínimas para o saque: se é admin, se possui saldo e se a conta é verificada.

        if('admin' == Auth::guard('web')->user()->permissao){
            if ($request->valor <= Empresa::where('cnpj', '=', Auth::guard('web')->user()->cnpj_empresa)->first()->saldo_empresa) {
                if(Conta::where('num_conta', '=', $request->num_conta)->first()->verificada){                
                   
                    //operação para adicionar os dados de envio de email a request.
                    $request->merge([
                        'cnpj'=> Auth::guard('web')->user()->cnpj_empresa,
                        'name'=> Auth::guard('web')->user()->name,
                        'email'=> Auth::guard('web')->user()->email,
                    ]);
                    //Atribui a um job a tarefa de fazer a transação na conta.                                        
                    Pagamento::dispatch($request->all());
                    return redirect(RouteServiceProvider::HOME);  
                }
                else{
                    return view('dashboard','[A conta não é verificada, por favor tente outra]');
                }
            }
            else{
                return view('dashboard','[A empresa não tem saldo suficiente]');
            }
        }else{
            return view('dashboard', '[Só admin pode solicitar saque]');
        }
        
    }

    /**
     * Método responsável por adicionar uma nova conta ao sistema e verificar se os dados 
     * da request são válidos para a operação.
     * 
     * @param  Illuminate\Http\Request;  $request
     * @return App\Providers\RouteServiceProvider
     */
    public function adicionarConta(Request $request){
        $request->validate([
          'num_conta'=>'required|max:15',
          'proprietario'=>'required|string:255',                
        ]);
        Conta::create([
          'num_conta'=> $request->num_conta,
          'proprietario'=> $request->proprietario,
          'verificada'=> false,
          'saldo'=>0,
        ]);
        
        return redirect(RouteServiceProvider::HOME);  
    }  

    /**
     * Método responsável por verificar uma conta do sistema e verificar se os dados 
     * da request são válidos para a operação.
     *
     * @param  Illuminate\Http\Request;  $request
     * @return App\Providers\RouteServiceProvider
     */
    public function verificarConta(Request $request){
        $request->validate([
            'num_conta'=>'required|max:15',                         
        ]);
        Conta::where('num_conta', '=', $request->num_conta)->first()->update(['verificada' => true]);
        return redirect(RouteServiceProvider::HOME);  
    }

}
