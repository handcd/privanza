<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminNewEvent extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The event
     * @var App\Event
     */
    protected $evento;

    /**
     * Create a new notification instance.
     *
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
                    ->subject('Nueva Cita en Privanza')
                    ->line('Se ha generado una cita nueva en el sistema. Se ha generado para que '.$this->evento->vendedor->name.' visite a '.$this->evento->client->name.' el próximo '.$this->evento->fechahora.'.')
                    ->line('Para revisar esta cita, puedes hacer click en el siguiente botón:')
                    ->action('Revisar Cita', url('/admin/citas',$this->evento->id))
                    ->line('¡Gracias por usar el sistema!');
    }
}
