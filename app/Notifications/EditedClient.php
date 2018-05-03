<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EditedClient extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The User and the Client
     * @var $user
     * @var \App\Client $client
     */
    protected $user;
    protected $client;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $client)
    {
        $this->user = $user;
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
        if ($this->user->isAdmin()) {
            return (new MailMessage)
                        ->subject('Se ha editado la información de un Cliente')
                        ->line('La información del cliente '.$this->client->name.' '.$this->client->lastaname.' con ID #'.$this->client->id.' ha sido modificada.')
                        ->line('Para ver la información actualizada haz click en el siguiente botón:')
                        ->action('Ver Cliente',url('/admin/clientes',$this->client->id))
                        ->line('¡Gracias por usar el Sistema!');
        } elseif ($this->user->isValidador()) {
            return (new MailMessage)
                        ->subject('Se ha editado la información de un Cliente')
                        ->line('La información del cliente '.$this->client->name.' '.$this->client->lastaname.' con ID #'.$this->client->id.' ha sido modificada.')
                        ->line('Para ver la información actualizada haz click en el siguiente botón:')
                        ->action('Ver Cliente',url('/validador/clientes',$this->client->id))
                        ->line('¡Gracias por usar el Sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Se modificó la información de un Cliente')
                        ->line('Se ha modificado la información de tu cliente '.$this->client->name.' '.$this->client->lastname.'. Para revisar este y  otros cambios haz click en el siguiente botón:')
                        ->action('Ver Cliente', url('/vendedor/clientes',$this->client->id))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
