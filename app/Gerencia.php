<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class Gerencia extends Model
{
    protected $table="ma_gerencia";
    protected $with=["empresa"];

    protected $fillable=["nombre","descripcion","color","id_empresa","estado"];
    public static function query()
    {
        $query= (new static)->newQuery()->select(['ma_gerencia.id', 'ma_gerencia.nombre as nombregerencia', 'ma_gerencia.descripcion', 'ma_gerencia.color', 'id_empresa','ma_gerencia.estado']);
        $user=auth()->user();
        if ($user) {
            if($user->perfil==1 && $user->holding_id && $user->empresa_id && $user->gerencia_id)
                $query = $query
                    ->whereIn('id_empresa', 
                        function($q) use ($user){                        
                            $q->from('ma_empresa')->select('id')->where('id_holding', $user->holding_id);
                        });
            if($user->perfil==2 && $user->holding_id && $user->empresa_id && $user->gerencia_id)
                $query = $query->where("id_empresa", $user->empresa_id);
            if($user->perfil>2 && $user->holding_id && $user->empresa_id && $user->gerencia_id)
                $query=$query->where("id",$user->gerencia_id);
        }
        return $query;
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class,"id_empresa","id");
    }
}
