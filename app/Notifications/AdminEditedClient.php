<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminEditedClient extends Notification implements ShouldQueue
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
                    ->subject('Un cliente ha sido modificado')
                    ->line('La información del cliente #'.$this->client->id.' ('.$this->client->name.') ha sido modificada. Para revisar los cambios, haz click en el siguiente botón:')
                    ->action('Revisar Cliente',url('/admin/clientes',$this->client->id))
                    ->line('¡Gracias por usar el sistema!');
    }
}
