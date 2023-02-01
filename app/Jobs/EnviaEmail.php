<?php

namespace App\Jobs;

use App\Mail\NotificaPagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use stdClass;

class EnviaEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $request;
    public $tries = 3;

    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {     
        
        $dados = new stdClass();
        $dados->info = $this->request['info'];
        
        Mail::send('email.modelo', ['user' => $dados], function ($message) {
            $message->subject('Notificação Sobre o Pagamento');        
            $message->to($this->request['email'], $this->request['name']);
        });
             
    }
}
