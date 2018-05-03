<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewAdjustment extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The User and the AdjustmentsOrder
     * @var $user
     * @var \App\AdjustmentsOrder $adjustment
     */
    protected $user;
    protected $adjustment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $adjustment)
    {
        $this->user = $user;
        $this->adjustment = $adjustment;
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
                        ->subject('Nueva Orden de Ajustes en Privanza')
                        ->line('Se ha añadido una nueva orden de ajustes en el sistema. Puedes revisarla haciendo click en el siguiente botón:')
                        ->action('Revisar Orden de Ajsutes',url('/admin/ajustes',$this->adjustment->id))
                        ->line('¡Gracias por usar el sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Nueva Orden de Ajustes en Privanza')
                        ->line('Se ha añadido una nueva orden de ajustes en el sistema. Puedes revisarla haciendo click en el siguiente botón:')
                        ->action('Revisar Orden de Ajsutes',url('/ajustes/ajustes',$this->adjustment->id))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
