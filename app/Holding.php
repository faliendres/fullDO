<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holding extends Model
{
    protected $table = "ma_holding";
protected $fillable=["nombre","logo","descripcion","color"];
    public static function query()
    {
        $query = (new static)->newQuery();
        $user = auth()->user();
        if ($user && $user->perfil > 0 &&$user->holding_id)
            $query = $query->where("id", $user->holding_id);
        return $query;

    }
}
