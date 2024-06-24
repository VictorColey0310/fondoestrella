<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EstadoSolicitud extends Notification
{
    use Queueable;
    protected $name;
    protected $estado;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name,$estado)
    {
        $this->name = $name;
        $this->estado = $estado;
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
            ->subject('¡Su solicitud cambio de estado!')
            ->greeting('¡Hola, ' . $this->name . '!')
            ->line('Su solicitud ha sido '. $this->estado )
            ->action('Ver solicitud', url('/solicitudes'));
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
