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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->usuario_creaction = auth()->id();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'apellido', 'email', 'password',
        "perfil", "usuario_creacion", "estado", "rut",
        'gerencia_id', 'empresa_id', 'holding_id'];


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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
