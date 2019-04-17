<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class EmailUserLogin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

   // public $email; 

    public function __construct( $email, $password )
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::where('email',$this->email)->first();
        return $this->from('example@fulldo.com')
                    ->subject('Bienvenid@')
                    ->markdown('emails.user_login')
                    ->with([
                    'password' => $this->password,
                    'usuario' => $user->rut,
                    'nombre' => $user->name . ' ' . $user->apellido,
                    'logoEmpresa' => $user->empresa->logo
        ]);

    }
}
