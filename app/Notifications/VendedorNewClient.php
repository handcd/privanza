<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VendedorNewClient extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Client
     * @var \App\Client $client
     */
    protected $client;

    /**
     * Create a new notification instance.
     *
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
                    ->subject('Tienes un cliente nuevo')
                    ->line('Se te ha asignado un cliente nuevo. Para revisarlo, puedes hacer click en el siguiente botón:')
                    ->action('Revisar Cliente',url('/vendedor/clientes',$this->client->id))
                    ->line('¡Gracias por usar el sistema!')
    }
}
