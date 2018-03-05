<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminDelayedOrder extends Notification implements ShouldQueue
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
                    ->subject('Notificación de Pedido Atrasado')
                    ->line('Te enviamos este correo para informarte que el pedido #'.$this->order->id.' de '.$this->order->vendedor->name.' '$this->order->vendedor->name.' para '.$this->order->client->name.' '.$this->order->vendedor->lastname.' se ha atrasado en el flujo de trabajo de Privanza.')
                    ->line('Para revisar el estado del pedido haz click en el siguiente botón:')
                    ->action('Revisar Pedido', url('/admin/ordenes',$this->order->id))
                    ->line('¡Gracias por usar el sistema!');
    }
}
