<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminNewClient extends Notification implements ShouldQueue
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
                    ->subject('Un nuevo cliente ha sido añadido al sistema')
                    ->line('Se ha añadido un nuevo cliente al sistema bajo el nombre de: '.$this->client->name.' y fue asignado al vendedor '.$this->client->vendedor->name.'. Para ver el cliente a detalle, haz click en el siguiente botón:')
                    ->action('Revisar Cliente',url('/admin/clientes',$this->client->id))
                    ->line('¡Gracias por usar el sistema!');
    }
}
