<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    const TIPOS = ["A", "B", "C"];

    protected $table = "solicitudes";
    protected $with = ["destinatario"];
    protected $fillable = ["tipo", "destinatario_id", "asunto", "descripcion","adjuntos"];

    public function destinatario()
    {
        return $this->belongsTo(User::class);
    }
}
