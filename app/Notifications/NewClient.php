<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewClient extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Client and the User to be notified
     * @var \App\Client $client
     * @var $user
     */
    protected $client;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $client)
    {
        $this->client = $client;
        $this->user = $user;
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
        if ($this->user->isAdmin()) {
            return (new MailMessage)
                        ->subject('Nuevo Cliente añadido al Sistema')
                        ->line('Un nuevo cliente ha sido añadido al sistema.')
                        ->line('Nombre: '.$this->client->name.' '.$this->client->lastname)
                        ->line(' Para revisar su información, haz click en el siguiente botón:')
                        ->action('Revisar Cliente',url('/admin/clientes',$this->client->id))
                        ->line('¡Gracias por usar el sistema!');
        } elseif ($this->user->isValidador()) {
            return (new MailMessage)
                        ->subject('Nuevo Cliente añadido al Sistema')
                        ->line('Un nuevo cliente ha sido añadido al sistema.')
                        ->line('Nombre: '.$this->client->name.' '.$this->client->lastname)
                        ->line(' Para revisar su información, haz click en el siguiente botón:')
                        ->action('Revisar Cliente',url('/validador/clientes',$this->client->id))
                        ->line('¡Gracias por usar el sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Se te ha añadido un nuevo Cliente')
                        ->line('Un nuevo cliente ha sido añadido para que lo atiendas.')
                        ->line('Nombre: '.$this->client->name.' '.$this->client->lastname)
                        ->line('Para revisar los datos completos del cliente, así como añadir una cita o un pedido, puedes hacerlo haciendo click en el siguiente botón:')
                        ->action('Revisar Cliente',url('/vendedor/clientes',$this->client->id))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
