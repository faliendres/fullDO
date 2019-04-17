<?php

namespace App\Notifications;

use App\Notifications\Lang;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportReadyNotification extends Notification
{

    protected $creados;
    protected $type;

    /**
     * ImportReadyNotification constructor.
     * @param array $creados
     */
    public function __construct( $creados, $type)
    {
        $this->creados = $creados;
        $this->type = $type;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail= (new MailMessage)
            ->subject('Carga masiva realizada')
            ->greeting('Hola ' . $notifiable->name)
            ->line("Se registraron ". ($this->creados)." $this->type nuevos")
            ->salutation('Saludos!');
        return $mail;
    }


}
