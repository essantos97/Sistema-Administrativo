<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriarContaRequest;
use App\Http\Requests\SaqueRequest;
use App\Jobs\Pagamento;
use App\Models\Conta;
use App\Models\Empresa;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;

class AdminController extends Controller
{
    private $usuario;
    public function __construct(User $usuario)
    {
        $this->usuario = $usuario;
    }

    public function index(){
                       
        $empresas  = Empresa::where('cpf_admin','=', Auth::guard('web')->user()->cpf)->first();  
        $contas  = Conta::where('cpf_admin','=', Auth::guard('web')->user()->cpf)->get();                      
        return view('dashboard', compact('empresas', 'contas'));
    }

   /**
     * Método responsável por verificar se os dados mínimos e obrigatórios para o saque(pagamento)
     * estão corretos e fazer as verificações necessárias para criar o job de saque que fará a 
     * transação no sistema.
     *
     * @param  Illuminate\Http\SaqueRequest;  $request
     * @return App\Providers\RouteServiceProvider
     * @return \Illuminate\View\View
     */
    public function saque(SaqueRequest $request){        
                
        try {
            if('admin' == Auth::guard('web')->user()->permissao){
                try {
                    if ($request->valor <= Empresa::where('cnpj', '=', Auth::guard('web')->user()->cnpj_empresa)->first()->saldo_empresa) {
                        try {
                            $buscaConta = Conta::where('num_conta', '=', $request->num_conta)->first();
                            if (!null == $buscaConta) {
                                try {
                                    if($buscaConta->verificada == true){                
                                                          
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
                                        throw new Exception("A conta não é verificada, por favor tente outra.", 1);                                 
                                    }
                                } catch (Exception $e) {
                                    return back()->with('msg', $e->getMessage());
                                }
                            }else{
                                throw new Exception("A conta não foi encontrada, verifique o número.", 1);
                            }
                        } catch (Exception $e) {                                                                                                                    
                            return back()->with('msg', $e->getMessage());
                        }
                    }
                    else{
                        throw new Exception("A empresa não tem saldo suficiente.", 1);                        
                    }
                } catch (Exception $e) {                                                                                                                    
                    return back()->with('msg', $e->getMessage());
                }
            }else{
                throw new Exception("Apenas administradores podem solicitar saque.", 1);
            }
        } catch (Exception $e) {                                                                                                                    
            return back()->with('msg', $e->getMessage());
        }        
        
    }

    /**
     * Método responsável por adicionar uma nova conta ao sistema, recebe uma requisição já validada
     *  e cria uma nova conta.
     * 
     * @param  Illuminate\Http\CriarContaRequest;  $request
     * @return App\Providers\RouteServiceProvider
     */
    public function adicionarConta(CriarContaRequest $request){
        
        Conta::create([
          'num_conta'=> $request->num_conta,
          'proprietario'=> $request->proprietario,
          'verificada'=> false,
          'cpf_admin' => Auth::guard('web')->user()->cpf,
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
            'num_conta'=>'required|integer|max:999999999999999',                         
        ],[
            'num_conta.required'=>'O número da conta é obrigatório',            
            'num_conta.integer'=>'O número da conta é totalmente numérico.',
            'num_conta.max'=>'O número da conta deve ter no máximo 15 numeros.',                      
        ]);        
        
        
        try {

            $busca = Conta::where('num_conta', '=', $request->num_conta)->first();   

            if (null == $busca) {                    
                throw new Exception("Não foi possível encontrar a conta.", 1);
            }elseif($busca->verificada == true){
                throw new Exception("A conta já é verificada.", 2);
            }else{                    
                $busca->update(['verificada' => true]);    
                return redirect(RouteServiceProvider::HOME);                
            }
        } catch (Exception $e) {
                                                                                                                    
            return back()->with('msg', $e->getMessage());
        }
                                    
    }

}
