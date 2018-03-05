<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class AdminInvoicedOrder extends Notification implements ShouldQueue
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
     * @param \App\Order
     * @return void
     */
    public function __construct($orden)
    {
        $this->order = $orden;
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
                    ->subject('Se ha facturado la Orden #'.$this->order->id)
                    ->line('Se ha enviado la factura para el pedido #'.$this->order->id.' de '.$this->order->client->name.' '.$this->order->client->lastname.' por el monto de $'.$this->order->precio.' el día '.Carbon::now()->toDateTimeString())
                    ->line('Para revisar la factura haz click en el siguiente botón:')
                    ->action('Revisar Factura', url('/admin/ordenes/'.$this->order->id.'/factura'))
                    ->line('¡Gracias por usar el sistema!');
    }
}
