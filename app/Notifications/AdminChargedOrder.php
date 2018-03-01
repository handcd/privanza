<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminChargedOrder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The order
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
        return (new MailMessage)
                    ->subject('Pedido #'.$this->order->id.' pagado')
                    ->line('El pedido número #'.$this->order->id.' ha sido pagado.')
                    ->line('El pedido fue ingresado por '.$this->order->vendedor->name.' '.$this->order->vendedor->lastname.' el '.$this->order->created_at.'.')
                    ->line('Fecha de Pago: '.$this->date_cobrado)
                    ->line('Monto de Pago: '.$this->precio)
                    ->action('Revisar Pedido', url('/admin/ordenes',$this->order->id))
                    ->line('¡Gracias por usar el sistema Privanza!');
    }
}
