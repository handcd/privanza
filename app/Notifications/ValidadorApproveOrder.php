<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ValidadorApproveOrder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Order
     * @var \App\Order
     */
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
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
                    ->subject('Recordatorio: Aprobar Orden')
                    ->line('Han pasado 24 horas desde que el pedido #'.$this->order->id.' por '.$this->order->vendedor->name.' fue ingresado y no ha sido revisado.')
                    ->line('Te recomendamos que revises su status para su aprobación o modificación para mantener la línea de trabajo funcionando correctamente.')
                    ->action('Revisar Orden', url('/validador/ordenes'),$this->order->id)
                    ->line('¡Gracias por usar el sistema!');
    }
}
