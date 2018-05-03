<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderProductionAssemble extends Notification implements ShouldQueue
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
                        ->subject('Una Orden ha sido marcada como en Producción - Ensamble')
                        ->line('La orden #'.$this->order->id. ' con número de Orden de Producción #'.$this->order->consecutivo_op.' ha sido marcada como en **producción - ensamble**. Para revisar más detalles de la misma, haz click en el siguiente botón:')
                        ->action('Revisar Orden',url('/admin/ordenes',$this->order->id))
                        ->line('¡Gracias por usar el Sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Una Orden ha sido marcada como en Producción - Ensamble')
                        ->line('La orden #'.$this->order->id. ' con número de Orden de Producción #'.$this->order->consecutivo_op.' ha sido marcada como en **producción - ensamble**. Para revisar más detalles de la misma, haz click en el siguiente botón:')
                        ->action('Revisar Orden',url('/validador/ordenes',$this->order->id))
                        ->line('¡Gracias por usar el Sistema!');
        }
    }
}
