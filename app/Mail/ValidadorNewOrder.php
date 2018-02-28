<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ValidadorNewOrder extends Mailable
{
    use Queueable, SerializesModels;

    // Current Order
    protected $order;

    /**
     * Create a new message instance.
     *
     * @param App\Order
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
        // Variables for the message
        $asunto = 'Nuevo Pedido Recibido';
        $titulo = $this->order->vendedor->name.' ha registrado una orden nueva.';
        $cuerpo = 'El vendedor '.$this->order->vendedor->name.' ha registrado una orden para el cliente '.$this->order->client->name.'. El pedido se registró el '.$this->order->created_at.' y no ha sido revisado. Para revisarlo haz click en el siguiente botón:';
        $mensajeAccion = 'Revisar Pedido';
        $urlAccion = '/validador/ordenes/'.$this->order->id;

        // Render view with data
        return $this->view('mails.action',compact('asunto','titulo','cuerpo','mensajeAccion','urlAccion'));
    }
}
