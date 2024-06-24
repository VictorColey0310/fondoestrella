<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Solicitud extends Notification
{
    use Queueable;

    
    protected $name;



    /**
     * Create a new notification instance.
     * @param string $name
     * @param string $document
     * @return void
     

     */
    public function __construct($name)
    {
        $this->name = $name;

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
            ->subject('¡Nueva solicitud!')
            ->greeting('¡Hola, ' . $this->name . '!')
            ->line('Tienes una nueva solicitud')
            ->action('Ver solicitud', url('/gestionar_solicitudes'));
            
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
