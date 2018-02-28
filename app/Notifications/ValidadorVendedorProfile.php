<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ValidadorVendedorProfile extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Vendedor
     * @var \App\Vendedor
     */
    protected $vendedor;

    /**
     * Create a new notification instance.
     *
     * @param \App\Vendedor $vendedor
     * @return void
     */
    public function __construct($vendedor)
    {
        $this->vendedor = $vendedor;
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
                    ->subject('Cambio de Información de Vendedor')
                    ->line($this->vendedor->name.' '.$this->vendedor->lastname.' ha solicitado un cambio de información. Para esto a continuación te proporcionaremos los datos de contacto del/la vendedor/a:')
                    ->line('Correo Electrónico: '.$this->vendedor->email)
                    ->line('Teléfono: '.$this->vendedor->email)
                    ->action('Revisar Vendedor', url('/validador/vendedores/',$this->vendedor->id))
                    ->line('¡Gracias por usar el sistema!');
    }
}
