<?php

namespace App\Jobs;

use App\Models\Conta;
use App\Models\Empresa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class Pagamento implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $request;
    public $tries = 2;
    protected $req;
    public function __construct($request)
    {                
        $this->request = $request;  
        
        //$req = new Request($request->all());
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        DB::beginTransaction();

        try {
            
            Conta::where('num_conta', '=', $this->request['num_conta'])->increment('saldo', $this->request['valor']);
            Empresa::where('cnpj', '=', $this->request['cnpj'])->decrement('saldo_empresa', $this->request['valor']);
            
            $mensagem=[
                'info'=> 'O pagamento para a conta: '. $this->request['num_conta'] .' no valor de R$'.$this->request['valor']. ', foi concluído com sucesso!',            
             ]; 
            
            EnviaEmail::dispatch($this->request+$mensagem);            
            DB::commit();
                    
        } catch (\Exception $e) {
            
            $mensagem=[
                'info'=> 'O pagamento para a conta: '. $this->request['num_conta'] .' no valor de R$'.$this->request['valor']. ', não pôde ser concluido, o valor já foi devolvido a conta da empresa!',            
             ]; 
            
            EnviaEmail::dispatch($this->request+$mensagem); 
            DB::rollback();

        }
    }
        
        
}
