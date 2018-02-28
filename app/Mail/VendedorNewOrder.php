<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VendedorNewOrder extends Mailable
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
    public function __construct($orden)
    {
        $this->order = $orden;
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
        $titulo = 'Tu pedido ha sido registrado correctamente.';
        $cuerpo = 'Tu pedido para '.$this->order->client->name.' se registró correctamente. El pedido tiene un número de orden #'.$this->order->id.' y se encuentra en proceso de aprobación para su cotización. Si deseas consultar el pedido o revisar su estado actual puedes hacer click en el siguiente botón:';
        $mensajeAccion = 'Revisar Pedido';
        $urlAccion = '/vendedor/ordenes/'.$this->order->id;

        // Render view with data
        return $this->view('mails.action',compact('asunto','titulo','cuerpo','mensajeAccion','urlAccion'));
    }
}
