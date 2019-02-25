<?php

namespace App\Http\Controllers;


use App\Solicitud;
use Illuminate\Validation\Rule;

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


}
