<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ValidadorNewEvent extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The event
     * @var \App\Event
     */
    protected $evento;

    /**
     * Create a new notification instance.
     *
     * @param \App\Event $evento
     * @return void
     */
    public function __construct($evento)
    {
        $this->evento = $evento;
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
                    ->subject('Nueva Cita')
                    ->line('Se ha añadido una nueva cita para que '.$this->evento->vendedor->name.' visite a '.$this->evento->client->name.' el próximo '.$this->evento->fechahora.'. Si deseas reivsar la cita, puedes hacerlo haciendo click en el siguiente botón:')
                    ->action('Revisar Cita', url('/validador/citas',$this->evento->id))
                    ->line('¡Gracias por usar el sistema!');
    }
}
