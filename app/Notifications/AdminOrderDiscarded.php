<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class AdminOrderDiscarded extends Notification implements ShouldQueue
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
                    ->subject('Una orden ha sido eliminada')
                    ->line('El pedido #'.$this->order->id.' de '.$this->order->vendedor->name.' '$this->order->vendedor->lastname.' para '.$this->order->client->name.' '.$this->order->client->lastname.' ha sido eliminado el día '.Carbon::now()->toDateTimeString())
                    ->line('Puedes ponerte en contacto con los validadores para corroborar los motivos de esta acción.')
    }
}
