<?php

namespace App;

use App\Exceptions\LoopReferenceException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'ma_cargo';
    protected $with = ["gerencia","funcionario","jefatura"];
    protected $fillable = ["nombre", "descripcion", "id_jefatura", "id_funcionario", "id_gerencia", "area", "desde", "hasta", "color","estado"];

    public function jefatura()
    {
        return $this->belongsTo(Cargo::class, "id_jefatura", "id");
    }

    public function subCargos(){
        return $this->hasMany(Cargo::class,"id_jefatura","id");
    }

    public function gerencia()
    {
        return $this->belongsTo(Gerencia::class, "id_gerencia", "id");
    }

    public function funcionario()
    {
        return $this->belongsTo(User::class,
            "id_funcionario", "id");
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->id_funcionario) {
                $cargos = Cargo::query()
                    ->where("id_funcionario", $model->id_funcionario)->get();
                foreach ($cargos as $cargo) {
                    $cargo->id_funcionario = null;
                    $cargo->update();
                }
            }

            if($model->id_jefatura){
                $model->isSubCargo($model->id_jefatura);
                //throw  new LoopReferenceException;
            }

        });
        self::saved(function ($model) {
            $user = User::find($model->id_funcionario);
            if ($user) {
                $user->updated_at = Carbon::now();
                $user->update();
            }
        });

        static::updating(function ($model) {
            Cargo::query()
                ->where("id", "<>", $model->id)
                ->where("id_funcionario", $model->id_funcionario)->update(["id_funcionario" => null]);
            if($model->id_jefatura){
                $model->isSubCargo($model->id_jefatura);
                //throw  new LoopReferenceException;
            }

        });
        static::updated(function ($model) {
            $user = User::find($model->id_funcionario);
            if ($user) {
                $user->updated_at = Carbon::now();
                $user->update();
            }
        });

    }

    public static function query()
    {
        $query = (new static)->newQuery();
        $user = auth()->user();
        if ($user && $user->perfil > 2 && $user->holding_id && $user->empresa_id && $user->gerencia_id)
            $query = $query->where("id_gerencia", $user->gerencia_id);
        return $query;
    }


    public function isSubCargo($cargo_id){
        if(!in_array($cargo_id,$this->subCargos->pluck("id")->all()))
            return true;
        foreach ($this->subCargos as $cargo){
            if($cargo->isSubCargo($cargo_id)){
                return true;
            }
        }
        return false;
    }


    public function getDesdeAttribute($desde){
        return Carbon::parse($desde)->format('d-m-Y');
    }
    public function getHastaAttribute($hasta){
        return Carbon::parse($hasta)->format('d-m-Y');
    }
}
