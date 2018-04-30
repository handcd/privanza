<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EditedAdjustment extends Notification implements ShouldQueue
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
                        ->subject('Se ha actualizado una Orden de Ajustes')
                        ->line('Se ha modificado la información de la Orden de Ajustes con ID #'.$this->adjustment->id.'. Para revisar más detalles haz click en el siguiente botón:')
                        ->action('Revisar Orden de Ajustes',url('/admin/ajustes',$this->adjustment->id))
                        ->line('¡Gracias por usar el sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Se ha actualizado una Orden de Ajustes')
                        ->line('Se ha modificado la información de la Orden de Ajustes con ID #'.$this->adjustment->id.'. Para revisar más detalles haz click en el siguiente botón:')
                        ->action('Revisar Orden de Ajustes',url('/validador/ajustes',$this->adjustment->id))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
