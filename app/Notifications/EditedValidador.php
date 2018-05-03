<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EditedValidador extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The user and the validador 
     * @var $user
     * @var \App\Validador $validador
     */
    protected $user;
    protected $validador;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $validador)
    {
        $this->user = $user;
        $this->validador = $validador;
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
        if ($this->user->isValidador()) {
            return (new MailMessage)
                        ->subject('Se ha actualizado tu información en Privanza')
                        ->line('Tu información ha sido actualizada en el sistema, para consultar los cambios haz click en el siguiente botón:')
                        ->action('Revisar mi Perfil',url('/validador/perfil'))
                        ->line('¡Gracias por usar el sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Se ha actualizado la información de un Validador')
                        ->line('Se ha actualizado la información del Validador: '.$this->validador->name.' '.$this->validador->lastname.' recientemente. Si deseas revisar la información que se ha actualizado haz click en el siguiente botón:')
                        ->action('Revisar Validador',url('/admin/validadores',$this->validador->id))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
