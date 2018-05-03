<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VendedorEnabled extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The user to be notified and the vendedor
     * @var $user
     * @var \App\Vendedor $vendedor
     */
    protected $user;
    protected $vendedor;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $vendedor)
    {
        $this->user = $user;
        $this->vendedor = $vendedor;
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
                        ->subject('La cuenta de '.$this->vendedor->name.' ha sido reactivada')
                        ->line('La cuenta del vendedor '.$this->vendedor->name.' '.$this->vendedor->lastname.' ha sido reactivada por lo que ya puede ingresar de nuevo al sistema para utilizarlo. Para revisar al vendedor, haz click en el siguiente botón:')
                        ->action('Revisar Vendedor',url('/admin/vendedores',$this->vendedor->id))
                        ->line('¡Gracias por usar el sistema!');
        } elseif ($this->user->isValidador()) {
            return (new MailMessage)
                        ->subject('La cuenta de '.$this->vendedor->name.' ha sido reactivada')
                        ->line('La cuenta del vendedor '.$this->vendedor->name.' '.$this->vendedor->lastname.' ha sido reactivada por lo que ya puede ingresar de nuevo al sistema para utilizarlo. Para revisar al vendedor, haz click en el siguiente botón:')
                        ->action('Revisar Vendedor',url('/validador/vendedores',$this->vendedor->id))
                        ->line('¡Gracias por usar el sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Tu cuenta ha sido reactivada')
                        ->line('Tu cuenta en Privanza ha sido reactivada. Puedes ingresar al sistema haciendo click en el siguiente botón:')
                        ->action('Entrar a Privanza',url('/vendedor/login'))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
