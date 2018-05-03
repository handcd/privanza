<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewValidador extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The user, the validador and the validador's password
     * @var $user
     * @var \App\Validador $validador
     * @var string $password
     */
    protected $user;
    protected $validador;
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $validador, $password = 'null')
    {
        $this->user = $user;
        $this->validador = $validador;
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
        if ($this->user->isValidador()) {
            return (new MailMessage)
                        ->subject('¡Bienvenid@ a Privanza!')
                        ->line($this->validador->name.' '.$this->validador->lastname.' te damos la más cordial bienvenida a la plataforma Web de Privanza, con esta plataforma podrás administrar Vendedores, Citas, Pedidos, Ajustes entre otras cosas.')
                        ->line('Para acceder al sistema sólamente requieres tu **correo electrónico** y tu **contraseña**. La contraseña ha sido generada automáticamente y te recomendamos que la cambies en cuanto tengas oportunidad. Tus datos de acceso son:')
                        ->line('Correo Electrónico: '.$this->validador->email)
                        ->line('Contraseña: '.$this->password)
                        ->line('Para acceder al sistema por primera vez haz click en el siguiente botón:')
                        ->action('Ingresar a la Plataforma',url('/validador/login'))
                        ->line('Te recordamos que **debes** cambiar tu contraseña, para esto puedes hacer click en "Olvidé mi Contraseña" en la pantalla de Inicio de Sesión y seguir el proceso correspondiente, de esta forma te asegurarás que _nadie más que tu_ tendrá acceso a tu cuenta.')
                        ->line('De nuevo, bienvenid@ y ¡Gracias por usar el Sistema!');
        } else {
            return (new MailMessage)
                        ->subject('Se ha añadido un nuevo Validador al Sistema')
                        ->line('Se ha añadido un nuevo Validador a Privanza, estos son sus datos más relevantes:')
                        ->line('**Nombre:** '.$this->validador->name.' '.$this->validador->lastname)
                        ->line('**Correo Electrónico:** '.$this->validador->email)
                        ->line('Para revisar más datos, haz click en el siguiente botón:')
                        ->action('Revisar Validador',url('/admin/validadores',$this->validador->id))
                        ->line('¡Gracias por usar el sistema!');
        }
    }
}
