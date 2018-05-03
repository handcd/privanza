<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ValidadorEnabled extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The user to be notified and the validador
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
        if ($this->user->isAdmin()) {
            return (new MailMessage)
                        ->subject('La cuenta de '.$this->validador->name.' ha sido reactivada')
                        ->line('La cuenta del validador '.$this->validador->name.' '.$this->validador->lastname.' ha sido reactivada por lo que ya puede ingresar de nuevo al sistema para utilizarlo. Para revisar al validador, haz click en el siguiente botón:')
                        ->action('Revisar validador',url('/admin/validadores',$this->validador->id))
                        ->line('¡Gracias por usar el sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Tu cuenta ha sido reactivada')
                        ->line('Tu cuenta en Privanza ha sido reactivada. Puedes ingresar al sistema haciendo click en el siguiente botón:')
                        ->action('Entrar a Privanza',url('/validador/login'))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
