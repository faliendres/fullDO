<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "ma_empresa";
    protected $fillable = ["rut",
        "nombre",
        "descripcion",
        "color",
        "desde",
        "hasta",
        "logo",
        "id_holding",
        "estado"];
    protected $with = ["holding"];

    public static function query()
    {
        $query = (new static)->newQuery();
        $user = auth()->user();
        if ($user && $user->perfil > 1 && $user->holding_id && $user->empresa_id)
            $query = $query->where("id", $user->empresa_id);
        return $query;
    }

    public function holding()
    {
        return $this->belongsTo(Holding::class, "id_holding", "id");
    }


    public function getDesdeAttribute($desde){
        return Carbon::parse($desde)->format('d-m-Y');
    }
    public function getHastaAttribute($hasta){
        return Carbon::parse($hasta)->format('d-m-Y');
    }
}
