<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use App\User;

class NewPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($newpass,$id)
    {
        $this->newpass = $newpass ;
        $this->id = $id ;
    }
    //

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::where('id',$this->id)->first();
        return $this->subject('Nueva Contraseña')
                   ->from('example@fulldo.com')
                   ->markdown('emails.newpass')
                   ->with([
                    'newPass' => $this->newpass,
                    'nombre' => $user->name . ' ' . $user->apellido,
                    'logoEmpresa' => $user->empresa->logo
        ]);
    }
}
