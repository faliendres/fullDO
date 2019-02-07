<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gerencia extends Model
{
    protected $table="ma_gerencia";
    public static function query()
    {
        $query= (new static)->newQuery();
        $user=auth()->user();
        if($user && $user->holding_id && $user->empresa_id && $user->gerencia_id)
            $query=$query->where("id",$user->gerencia_id);
        return $query;
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class,"id_empresa","id");
    }
}
