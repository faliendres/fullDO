<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    public $gerencia, $empresa, $holding, $cargo;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->usuario_creacion = auth()->id();
        });

        static::updating(function ($model) {
            if ($model->cargo)
                $model->gerencia = $model->cargo->gerencia;
            if ($model->gerencia) {
                $model->gerencia_id = $model->gerencia->id;
                $model->empresa = $model->cargo->gerencia->empresa;
                if ($model->empresa) {
                    $model->empresa_id = $model->empresa->id;
                    $model->holding = $model->cargo->gerencia->empresa->holding;
                    if ($model->holding)
                        $model->holding_id = $model->holding->id;
                }
            }
        });

    }

    public static function query()
    {
        $query = (new static)->newQuery();
        $user = auth()->user();
        if ($user) {
            /**
             * $user->perfil
             * 0: ROOT
             * 1: Holding Admin
             * 2: Empresa Admin
             * 3: Gerencia Admin
             */
            if ($user->perfil)
                $query = $query->where("perfil", '>=',$user->perfil);
            if ($user->perfil > 0)
                $query = $query->where("holding_id", $user->holding_id);
            if ($user->perfil > 1)
                $query = $query->where("empresa_id", $user->empresa_id);
            if ($user->perfil > 2)
                $query = $query->where("gerencia_id", $user->gerencia_id);
            if ($user->perfil > 3)
                $query = $query->where("id", $user->id);
        }
        return $query;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'apellido', 'email', 'password', "foto",
        "perfil", "usuario_creacion", "estado", "rut",
        'gerencia_id', 'empresa_id', 'holding_id'];

    public function cargo()
    {
        return $this->hasOne(Cargo::class, "id_funcionario", "id");
    }
    public function gerencia()
    {
        return $this->belongsTo(Gerencia::class, "gerencia_id", "id");
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, "empresa_id", "id");
    }

    public function holding()
    {
        return $this->belongsTo(Holding::class, "holding_id", "id");
    }


    public function autoload()
    {
        if ($this->cargo)
            $this->gerencia = $this->cargo->gerencia;
        if ($this->gerencia) {
            $this->empresa = $this->cargo->gerencia->empresa;
            if ($this->empresa) {
                $this->holding = $this->cargo->gerencia->empresa->holding;
            }
        }
        return true;
    }


    public static function find($id)
    {
        return User::query()->where("id", $id)->get()->first();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
