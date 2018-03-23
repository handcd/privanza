<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminEditedEvent extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The event
     * @var \App\Event $evento
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
                    ->subject('Una cita ha sido modificada')
                    ->line('La cita #'.$this->evento->id.' ha sido editada. Para revisar los datos de la misma, haz click en el siguiente botón:')
                    ->action('Revisar Cita', url('/admin/citas',$this->evento->id))
                    ->line('¡Gracias por usar el sistema!');
    }
}
