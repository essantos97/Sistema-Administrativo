<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
        Mail::queue('email.modelo', ['user' => $this->request['info']], function () {
            $this->subject('Notificação Sobre o Pagamento');        
            $this->to($this->request['email'], $this->request['name']);
        });
                
    }
}
