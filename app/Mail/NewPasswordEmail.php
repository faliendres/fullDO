<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class NewPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($newpass)
    {
        $this->newpass = $newpass ;
    }
    //

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->subject('Nueva Contraseña')
                   ->from('example@fulldo.com')
                   ->markdown('emails.newpass')
                   ->with([
                    'newPass' => $this->newpass,
        ]);
    }
}
