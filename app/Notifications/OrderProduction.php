<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderProduction extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The user and the order
     * @var $user
     * @var \App\Order $order
     */
    protected $user;
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $order)
    {
        $this->user = $user;
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
        if ($this->user->isAdmin()) {
            return (new MailMessage)
                        ->subject('Una Orden ha entrado a Producción')
                        ->line('La orden #'.$this->order->id. ' con número de Orden de Producción #'.$this->order->consecutivo_op.' ha entrado a **Producción**. Para revisar más detalles de la misma, haz click en el siguiente botón:')
                        ->action('Revisar Orden',url('/admin/ordenes',$this->order->id))
                        ->line('¡Gracias por usar el Sistema!');
        } elseif ($this->user->isValidador()) {
            return (new MailMessage)
                        ->subject('Una Orden ha entrado a Producción')
                        ->line('La orden #'.$this->order->id. ' con número de Orden de Producción #'.$this->order->consecutivo_op.' ha entrado **Producción**. Para revisar más detalles de la misma, haz click en el siguiente botón:')
                        ->action('Revisar Orden',url('/validador/ordenes',$this->order->id))
                        ->line('¡Gracias por usar el Sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Tu Orden ha entrado a Producción')
                        ->line('Tu orden con ID #'.$this->order->id.' ha entrado a **Producción**. Detalles rápidos de la orden:')
                        ->line('Cliente: '.$this->order->client->name.' '.$this->order->client->lastname)
                        ->line('Fecha de Creación: '.$this->order->created_at)
                        ->line('Precio final: '.$this->order->precio)
                        ->line('Para revisar más detalles, haz click en el siguiente botón:')
                        ->action('Revisar Orden',url('/vendedor/ordenes',$this->order->id))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
