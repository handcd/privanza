<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ValidadorNewClient extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The client
     * @var \App\Client $client
     */
    protected $client;

    /**
     * Create a new notification instance.
     *
     * @param \App\Client $client
     * @return void
     */
    public function __construct($client)
    {
        $this->client = $client;
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
                    ->subject('Se ha añadido un Cliente nuevo')
                    ->line('Se ha añadido un cliente nuevo al sistema. El cliente se llama: '.$this->client->name.' y está asignado al vendedor '.$this->client->vendedor->name.'. Para ver más detalles puedes ingresar haciendo click en el siguiente botón:')
                    ->action('Revisar Cliente',url('/validador/clientes',$this->client->id))
                    ->line('¡Gracias por usar el sistema!')
    }
}
