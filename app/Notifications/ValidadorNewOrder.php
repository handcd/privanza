<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ValidadorNewOrder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The order instance
     * @var \App\Order
     */
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @param \App\Order $order
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
        // URL
        $url = url('/validador/ordenes/',$this->order->id);

        return (new MailMessage)
                    ->subject('Nuevo Pedido Recibido')
                    ->greeting('Nuevo Pedido')
                    ->line($this->order->vendedor->name.' ha registrado un pedido nuevo para el cliente '.$this->order->client->name)
                    ->line('El pedido se registró el '.$this->order->created_at.' y no ha sido aprobado ni cotizado.')
                    ->action('Revisar Pedido', $url)
                    ->line('¡Gracias por usar el sistema!');
    }
}
