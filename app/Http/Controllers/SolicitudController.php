<?php

namespace App\Http\Controllers;


use App\Solicitud;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\SolicitudEmail;
use Log;


class SolicitudController extends Controller
{
    protected $clazz = Solicitud::class;
    protected $resource = "solicitudes";

    public function __construct()
    {
        $this->rules = [
            "tipo" => ["required", Rule::in(Solicitud::TIPOS)],
            "destinatario_id" => "required|exists:users,id",
            "asunto" => "required|max:190",
            "descripcion" => "required|max:255",
        ];
    }

    public function store(Request $request)
    {

        $result = parent::store($request);
        $solicitud = Solicitud::findOrFail($request->get("new_id"));

        try{
                Mail::to(User::findOrFail($solicitud->destinatario_id)->email)
                ->cc($request->user())
                ->send(new SolicitudEmail($solicitud));
                \Log::info('Envio correctamente el email');
            }
            catch(\Exception $e){ 
                \Log::info('-------Error Sending Mail: '.$e->getMessage());
            }

        return $result;

    }


}
