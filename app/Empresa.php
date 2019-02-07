<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table="ma_empresa";
    public static function query()
    {
        $query= (new static)->newQuery();
        $user=auth()->user();
        if($user && $user->autoload() && $user->holding_id && $user->empresa_id)
            $query=$query->where("id",$user->empresa_id);
        return $query;
    }

    public function holding(){
        return $this->belongsTo(Holding::class,"id_holding","id");
    }
}
