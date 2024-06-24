<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    protected $name;
    protected $documento;

    /**
     * Create a new notification instance.
     *
     * @param string $name
     * @param string $document
     * @return void
     */
    public function __construct($name, $documento)
    {
        $this->name = $name;
        $this->documento = $documento;
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
            ->subject('¡Bienvenido!')
            ->greeting('¡Hola, ' . $this->name . '!')
            ->line('Bienvenido a Fondo Estrella.')
            ->line('Ingrese al sistema con las siguientes credenciales:')
            ->line('Documento: ' . $this->documento)
            ->line('Contraseña: ' . $this->documento) // No mostrar la contraseña aquí, será obtenida después
            ->action('Iniciar sesión', url('/login'))
            ->line('Gracias por unirte a nosotros.');
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
