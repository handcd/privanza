<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EditedVendedor extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The User to be notified and the Vendedor
     * @var $user
     * @var \App\Vendedor $vendedor
     * @var string $password
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
                        ->subject('Se ha modificado la información de un Vendedor')
                        ->line('Se ha modificado la información de '.$this->vendedor->name.' '.$this->vendedor->lastname.' en el sistema, para revisar su información completa, haz click en el siguiente botón:')
                        ->action('Revisar Vendedor',url('/admin/vendedores',$this->vendedor->id))
                        ->line('¡Gracias por usar el Sistema!');
        } elseif ($this->user->isValidador()) {
            return (new MailMessage)
                        ->subject('Se ha modificado la información de un Vendedor')
                        ->line('Se ha modificado la información de '.$this->vendedor->name.' '.$this->vendedor->lastname.' en el sistema, para revisar su información completa, haz click en el siguiente botón:')
                        ->action('Revisar Vendedor',url('/validador/vendedores',$this->vendedor->id))
                        ->line('¡Gracias por usar el Sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Se ha actualizado tu información en Privanza')
                        ->line('Tu información ha sido actualizada, para revisar los cambios, haz click en el siguiente botón:')
                        ->action('Revisar Mi Perfil',url('/vendedor/profile'))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
