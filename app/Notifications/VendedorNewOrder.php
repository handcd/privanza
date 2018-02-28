<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VendedorNewOrder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Order Instance
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
        $url = url('/vendedor/ordenes/',$this->order->id);

        return (new MailMessage)
                    ->subject('Pedido Recibido')
                    ->greeting('Pedido Recibido')
                    ->line('Tu pedido para '.$this->order->client->name.' se registró correctamente.')
                    ->line('El pedido tiene el número de orden #'.$this->order->id.' y se encuentra en proceso de aprobación para su cotización.')
                    ->line('Para visualizar el estado actual, puedes hacer click en el siguiente botón:')
                    ->action('Revisar Pedido', $url)
                    ->line('¡Gracias por usar nuestro sistema!');
    }
}
