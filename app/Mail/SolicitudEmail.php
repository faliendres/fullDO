<?php

namespace App\Mail;

use App\Solicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use App\User;
use Log;

class SolicitudEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $solicitud ;

    public function __construct(Solicitud $solicitud, $id )
    {
        $this->solicitud = $solicitud ;
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

      //  \Log::info($this->solicitud->descripcion);
        $estados=collect(Solicitud::ESTADOS);
        $con_texto = ($estados->where('id',$this->solicitud->estado)->first())['text']; 
        $user = User::where('id',$this->id)->first();
           return $this->subject($this->solicitud->asunto)
                       ->from('example@fulldo.com')
                       ->markdown('emails.solicitud')
                       ->with([
                        'solicituDescripcion' => $this->solicitud->descripcion,
                        'solicituTipo' => Solicitud::TIPOS[$this->solicitud->tipo],
                        'solicituEstado' => $con_texto,
                        'nombre' => $user->name . ' ' . $user->apellido,
                        'logoEmpresa' => $user->empresa->logo
                ]);

    }
}
