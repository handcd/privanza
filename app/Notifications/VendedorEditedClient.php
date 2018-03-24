<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VendedorEditedClient extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Client
     * @var \App\Client $cliente
     */
    protected $cliente;

    /**
     * Create a new notification instance.
     *
     * @param \App\Cliente
     * @return void
     */
    public function __construct($cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Información de Cliente Modificada')
                    ->line('Se ha modificado la información de uno de tus clientes '.$this->cliente->vendedor->name.'. Para consultar los datos que han cambiado, puedes ingresar haciendo click en el siguiente botón:')
                    ->action('Revisar Cliente',url('/vendedor/clientes',$this->cliente->id))
                    ->line('¡Gracias por usar el sistema!');
    }
}
