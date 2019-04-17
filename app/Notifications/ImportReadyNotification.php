<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\Lang;

class ImportReadyNotification extends Notification
{
    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Carga masiva realizada')
        ->greeting('Hola '. $notifiable->name)
         ->line('Recibes este email porque se solicito un reestablecimiento de contraseña para tu cuenta')
         ->action('Restablecer contraseña', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Si no realizaste esta peticion, puedes ignorar este correo')
            ->salutation('Saludos!');
    }


}
