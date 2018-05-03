<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EditedEvent extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The User and the Event
     * @var $user
     * @var \App\Event $event
     */
    protected $user;
    protected $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $event)
    {
        $this->user = $user;
        $this->event = $event;
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
                        ->subject('Se ha modificado una cita')
                        ->line('La cita #'.$this->event->id.' del vendedor '.$this->event->vendedor->name.' con el cliente '.$this->event->client->name.' ha sido modificada. Para revisar más detalles haz click en el siguiente botón:')
                        ->action('Revisar Cita',url('/admin/citas',$this->event->id))
                        ->line('¡Gracias por usar el sistema!');
        } elseif ($this->user->isValidador()) {
            return (new MailMessage)
                        ->subject('Se ha modificado una cita')
                        ->line('La cita #'.$this->event->id.' del vendedor '.$this->event->vendedor->name.' con el cliente '.$this->event->client->name.' ha sido modificada. Para revisar más detalles haz click en el siguiente botón:')
                        ->action('Revisar Cita',url('/validador/citas',$this->event->id))
                        ->line('¡Gracias por usar el sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Una cita ha sido modificada - Privanza')
                        ->line('Una de tus citas ha sido modificada, para revisar la nueva información haz click en el siguiente botón:')
                        ->action('Revisar Cita',url('/vendedor/citas',$this->event->id))
                        ->line('¡Gracias por usar el Sistema!');
        }
    }
}
