<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EditedOrder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The user
     * @var $user
     */
    protected $user;

    /**
     * The Order
     * @var \App\Order $order
     */
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
        if ($user->isAdmin()) {
            return (new MailMessage)
                        ->subject('Se ha modificado el pedido #'.$this->order->id)
                        ->line('El pedido #'.$this->order->id.' ha sido modificado. Este pedido pertenece a '.$this->order->vendedor->name.' y fue ingresado el: '.$this->order->created_at.'.')
                        ->line('Para más información, haz cick en el botón de abajo:')
                        ->action('Revisar Pedido',url('/admin/ordenes',$this->order->id))
                        ->line('¡Gracias por usar el sistema!');
        } elseif ($user->isValidador()) {
            return (new MailMessage)
                        ->subject('Se ha modificado un pedido')
                        ->line('Se ha modificado información referente al pedido #'.$this->order->id.'. Este pedido le pertenece a '.$this->order->vendedor->name.' '.$this->order->vendedor->lastname.', para revisarlo haz click en el siguiente botón:')
                        ->action('Revisar Pedido', url('/validador/ordenes',$this->order->id))
                        ->line('¡Gracias por usar el sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Ha cambiado la información de tu pedido.')
                        ->line('Se ha cambiado la información de tu pedido para '.$this->order->client->name.' '.$this->order->client->lastname.'. Si deseas revisar el pedido, así como su status actualizado, puedes hacerlo haciendo click en el siguiente botón:')
                        ->action('Revisar Pedido',url('/vendedor/ordenes',$this->order->id))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
