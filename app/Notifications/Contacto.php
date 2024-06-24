<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Contacto extends Notification
{
    use Queueable;
    protected $nombre;
    protected $email;
    protected $descripcion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email, $nombre, $descripcion)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
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
            ->subject('¡Nuevo mensaje de contacto!')
            ->greeting('¡Hola')
            ->line('El usuario '. $this->nombre.'('.$this->email.'), ha dejado un mensaje:')
            ->line('"'. $this->descripcion.'."');
            //->action('Ver solicitud', url('/solicitudes'));
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
