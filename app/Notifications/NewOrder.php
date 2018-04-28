<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewOrder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Order
     * @var \App\Order
     */
    protected $order;

    /**
     * The User to be notified
     */
    protected $user;

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
                        ->subject('Nuevo Pedido añadido al Sistema')
                        ->line('Un nuevo pedido ha sido añadido al sistema. El pedido tiene un ID: '.$this->order->id.' y está asignada a '.$this->order->vendedor->name.' '.$this->order->vendedor->lastname.'.')
                        ->line('Para revisar más datos, así como el estado actual del pedido haz click en el siguiente botón:')
                        ->action('Revisar Pedido',url('/admin/ordenes',$this->order->id))
                        ->line('¡Gracias por usar el sistema!');
        } elseif ($this->user->isValidador()) {
            return (new MailMessage)
                        ->subject('Nuevo Pedido añadido al Sistema')
                        ->line('Un nuevo pedido ha sido añadido al sistema. El pedido tiene un ID: '.$this->order->id.' y está asignada a '.$this->order->vendedor->name.' '.$this->order->vendedor->lastname.'.')
                        ->line('Para revisar más datos, así como el estado actual del pedido haz click en el siguiente botón:')
                        ->action('Revisar Pedido',url('/validador/ordenes',$this->order->id))
                        ->line('¡Gracias por usar el sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Nuevo Pedido en Privanza')
                        ->line('Hemos registrado correctamente tu nuevo pedido para '.$this->order->client->name.' '.$this->order->client->lastname.'.')
                        ->line('Su número de pedido correspondiente es: '.$this->order->id.'. Para consultar el estado actual del pedido así como datos específicos, puedes hacerlo haciendo click en el siguiente botón:')
                        ->action('Revisar Pedido',url('/vendedor/ordenes',$this->order->id))
                        ->line('Te recordamos que una vez aprobado el pedido ya no será posible editarlo para ti y deberás comunicar cualquier cambio directamente con Privanza.')
                        ->line('¡Gracias por usar el sistema!');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
