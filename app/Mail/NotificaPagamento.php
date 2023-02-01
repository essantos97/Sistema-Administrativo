<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use stdClass;

class NotificaPagamento extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
        /*
        $dados = new stdClass();
        $dados->info = $this->request['info'];
        
        Mail::send('email.modelo', ['user' => $dados], function ($message) {
            $message->subject('Notificação Sobre o Pagamento');        
            $message->to($this->request['email'], $this->request['name']);
        });*/
                
    }
}
