<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MensajeDeBienvenida extends Mailable
{
    use Queueable, SerializesModels;
    public $asunto="Bienvenido a Mi Programateca";
    public $mensaje="aaaa";


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($unmensaje)
    {
        $this->mensaje=$unmensaje;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contacto_programateca@lucianoferrari.com.ar')
                ->view('emails.mensaje-de-bienvenida');
        
    }
}
