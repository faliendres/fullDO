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
        if($user && $user->holding_id && $user->empresa_id)
            $query=$query->where("id",$user->empresa_id);
        return $query;
    }
}
