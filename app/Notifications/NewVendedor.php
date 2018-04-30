<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewVendedor extends Notification implements ShouldQueue
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
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $vendedor, $password = 'null')
    {
        $this->user = $user;
        $this->vendedor = $vendedor;
        $this->password = $password;
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
                        ->subject('Se ha añadido un nuevo vendedor a Privanza')
                        ->line('Se ha añadido un nuevo vendedor a Privanza, estos son sus datos más relevantes:')
                        ->line('Nombre: '.$this->vendedor->name.' '.$this->vendedor->lastname)
                        ->line('Correo electrónico: '.$this->vendedor->email)
                        ->line('Para revisar más información, haz click en el botón:')
                        ->action('Revisar Nuevo Vendedor',url('/admin/vendedores',$this->vendedor->id))
                        ->line('¡Gracias por usar el sistema!');
        } elseif ($this->user->isVendedor()) {
            return (new MailMessage)
                        ->subject('¡Bienvenid@ a Privanza!')
                        ->line('Te damos la más cordial bienvenida al equipo de Vendedores de Privanza, una división de ISCO México.')
                        ->line($this->vendedor->name.' a partir de ahora cuentas con acceso a una plataforma web que te permitirá levantar pedidos, revisar el estado de los mismos, registrar citas con clientes así como revisar tus comisiones entre otras cosas.')
                        ->line('Para acceder al sistema sólamente requieres tu **usuario** y tu **contraseña**. El usuario, será **siempre** tu _email_ y tu contraseña ha sido generada automáticamente (te recomendamos que la cambies en cuanto accedas al sistema por una propia). Estos son tus datos iniciales de acceso:')
                        ->line('Usuario: '.$this->vendedor->email)
                        ->line('Contraseña: '.$this->password)
                        ->line('Para ingresar al sistema por primera vez haz click en el siguiente botón:')
                        ->action('Ingresar al Sistema',url('/vendedor/login'))
                        ->line('Te recordamos que porfavor **actualices tu contraseña** en cuanto ingreses, para esto puedes seguir el proceso haciendo click en "Olvidé Mi Contraseña" cuando inicies sesión y seguir el proceso.')
                        ->line('Una vez más, bienvenid@ y ¡Gracias por usar el Sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Se ha añadido un nuevo vendedor a Privanza')
                        ->line('Se ha añadido un nuevo vendedor a Privanza, estos son sus datos más relevantes:')
                        ->line('Nombre: '.$this->vendedor->name.' '.$this->vendedor->lastname)
                        ->line('Correo electrónico: '.$this->vendedor->email)
                        ->line('Para revisar más información, haz click en el botón:')
                        ->action('Revisar Nuevo Vendedor',url('/validador/vendedores',$this->vendedor->id))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
