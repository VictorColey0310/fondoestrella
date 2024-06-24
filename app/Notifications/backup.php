<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class backup extends Notification
{
    use Queueable;

    protected $name;
    protected $nombre;
    protected $urlArchivo;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $nombre, $urlArchivo)
    {
        $this->name = $name;
        $this->nombre = $nombre;
        $this->urlArchivo = $urlArchivo;
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
        ->subject('¡Backup automatizado! '. $this->nombre)
        ->greeting('¡Hola, ' . $this->name . '!')
        ->line('Esta es una copia de seguridad automatizada de '. $this->nombre )
        ->action('Descargar Backup', url($this->urlArchivo));
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
