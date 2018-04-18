<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Validador;

class ValidadorNew extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Validador
     * @var \App\Validador $validador
     */
    protected $validador;

    /**
     * The un-hashed temporal password
     * @var string $password
     */
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @param \App\Validador $validador
     * @param string $password
     * @return void
     */
    public function __construct($validador, $password)
    {
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
        return (new MailMessage)
                    ->subject('¡Bienvenido a Privanza!')
                    ->line('¡Te damos la más cordial bienvenida a Privanza '.$this->validador->name.'! Nuestra plataforma te ayuda a registrar órdenes y pedidos de forma más **fácil y rápida**.')
                    ->line('Para ello, cuentas con múltiples herramientas como: _Agenda de Citas, Registro de Clientes, Registro de Vendedores, Registro de Pedidos y Control de Proceso_. Todo esto para que puedas trabajar de forma cómoda y eficiente.')
                    ->line('Para comenzar a usarla, puedes ingresar con la siguiente información:')
                    ->line('Correo Electrónico: '.$this->validador->email)
                    ->line('Contraseña: '.$this->password)
                    ->line('Una vez ingresado, puedes dirigirte a `Mi Perfil` para que corrobores que la información registrada es correcta.')
                    ->line('Te recomendamos ampliamente que **cambies tu contraseña** una vez que ingreses al sistema. Para ello, puedes hacer click en `Olvidé Mi Contraseña` al iniciar sesión y seguir las instrucciones.')
                    ->line('Para ingresar al sistema puedes hacer click en el siguiente botón:')
                    ->action('Ingresar a Privanza',url('/validador/login'))
                    ->line('Cambiar la contraseña es decisión tuya y de nadie más, la contraseña que te estamos asignando no podrá ser visualizada por nadie más que tú.')
                    ->line('Toda la información que ingreses al sistema está protegida por nuestra **Política de Uso de Datos e Información** que puedes consultar en el sitio web.')
                    ->line('¡Gracias por usar Privanza!');
    }
}
