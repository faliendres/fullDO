<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    const TIPOS = ["A", "B", "C"];

    const ESTADOS = array(
		array(
			'text' => "Nueva",
			'id'  => "1"
		),		
		array(
			'text' => "Revision",
			'id'  => "2"
		),	
		array(
			'text' => "Completada",
			'id'  => "3"
		)
	);

    protected $table = "solicitudes";
    protected $with = ["destinatario"];
    protected $fillable = ["tipo", "remitente_id", "destinatario_id", "asunto", "descripcion","adjuntos","comentarios","estado"];

    public static function query()
    {
        $query = (new static)->newQuery();
        $user = auth()->user();
        if ($user && $user->perfil > 0)
            $query = $query->where("remitente_id", $user->id);
        return $query;

    }

    public function destinatario()
    {
        return $this->belongsTo(User::class);
    }
}
