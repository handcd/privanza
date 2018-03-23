<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Carbon\Carbon;

class VendedorNewEvent extends Notification implements ShouldQueue
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
                    ->subject('Tienes una nueva Cita')
                    ->line('Una nueva cita ha sido agendada para ti. Los detalles de la cita son:')
                    ->line('Cliente: '.$this->evento->client->name)
                    ->line('Dirección: '.$this->evento->client->address_visit)
                    ->line('Fecha: '.Carbon::parse($this->evento->fechahora)->toDateTimeString())
                    ->line('Si deseas más información, puedes consultar la cita haciendo click en el siguiente botón:')
                    ->action('Revisar Cita', url('/vendedor/citas',$this->evento->id))
                    ->line('¡Gracias por usar el sistema!');
    }
}
