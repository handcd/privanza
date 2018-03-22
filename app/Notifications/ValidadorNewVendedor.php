<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ValidadorNewVendedor extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Vendedor
     * @var Vendedor
     */
    protected $vendedor;

    /**
     * Create a new notification instance.
     *
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
                    ->subject('Nuevo Vendedor')
                    ->line('Se ha registrado un nuevo vendedor en el sistema. Datos del vendedor:')
                    ->line('Nombre: '.$this->vendedor->name)
                    ->line('Email: '.$this->vendedor->email)
                    ->line('Teléfono: '.$this->vendedor->phone)
                    ->line('Para ver más detalles y comenzar a trabajar, puedes revisar al vendedor haciendo click en el siguiente botón:')
                    ->action('Revisar Vendedor', url('/validador/vendedores',$this->vendedor->id))
                    ->line('¡Gracias por usar el sistema!');
    }
}
