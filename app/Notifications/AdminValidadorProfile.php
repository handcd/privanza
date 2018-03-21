<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminValidadorProfile extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The current Validador
     * @var App\Validador
     */
    protected $validador;

    /**
     * Create a new notification instance.
     *
     * @param App\Validador
     * @return void
     */
    public function __construct($validador)
    {
        $this->validador = $validador;
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
                    ->subject('Cambio de Información de Validador')
                    ->line($this->validador->name.' '.$this->validador->lastname.' ha solicitado un cambio de información. Para esto a continuación te proporcionaremos los datos de contacto del/la validador/a:')
                    ->line('Correo Electrónico: '.$this->validador->email)
                    ->line('Teléfono: '.$this->validador->phone)
                    ->action('Revisar Vendedor', url('/admin/validadores',$this->validador->id))
                    ->line('¡Gracias por usar el sistema!');
    }
}
