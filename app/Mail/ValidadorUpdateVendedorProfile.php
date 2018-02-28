<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ValidadorUpdateVendedorProfile extends Mailable
{
    use Queueable, SerializesModels;

    // Current Vendedor
    protected $vendedor;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vendedor)
    {
        $this->vendedor = $vendedor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Variables for the message
        $asunto = 'Cambio de Información de Vendedor';
        $titulo = $this->vendedor->name.' ha solicitado una revisión de información';
        $cuerpo = $this->vendedor->name.' '.$this->vendedor->lastname.' ha solicitado una revisión de su información. Para ponerse en contacto con él te proporcionamos su información de contacto y posteriormente podrás hacer los cambios pertinentes haciendo click en el botón. Correo: '.$this->vendedor->email.', Teléfono: '.$this->vendedor->phone;
        $mensajeAccion = 'Ver Vendedor';
        $urlAccion = '/validador/vendedores/'.$this->vendedor->id;

        // Render view with data
        return $this->view('mails.action',compact('asunto','titulo','cuerpo','mensajeAccion','urlAccion'));
    }
}
