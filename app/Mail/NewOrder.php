<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $asunto = 'Un nuevo pedido ha sido registrado';
        $urlAccion = '/validador/ordenes/'.$order->id;
        $cuerpo = 'Se ha ingresado un nuevo pedido por '.$order->vendedor->name.' que requiere su validación. Puede revisar el pedido haciendo click en el siguiente botón:';

        return $this->view('mails.action',compact('asunto','urlAccion','cuerpo'));
    }
}
