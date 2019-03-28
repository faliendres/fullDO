<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use App\Cargo;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Log;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->usuario_creacion = auth()->id();
        });

        static::updating(function ($model) {
            if ($model->cargo){
                $model->gerencia_id = $model->cargo->id_gerencia;
                $model->empresa_id = $model->cargo->gerencia->id_empresa;
                $model->holding_id = $model->cargo->gerencia->empresa->id_holding;
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
             * 4: Funcional
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
        "perfil", "telefono", "fecha_nacimiento", "fecha_inicio", "usuario_creacion", "estado", "rut",
        'gerencia_id', 'empresa_id', 'holding_id',"estado"];

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

    public static function get_nombre_cargo(){
        $jefatura = User::getJefatura(auth()->id());
        $empresaAdmins = User::getAdminEmpresa(auth()->user()->empresa_id);
        foreach ($empresaAdmins->get()->toArray() as $key => $value) {
            $arrayUsers[]=$value['id'];
        }
        if(isset($arrayUsers)){
            if(isset($jefatura->toArray()[0]))
                array_push($arrayUsers, $jefatura->toArray()[0]['id_funcionario']);
        }
        else if(isset($jefatura->toArray()[0]))
            $arrayUsers[] = $jefatura->toArray()[0]['id_funcionario'];
        else
            $arrayUsers = [];
        return User::leftJoin("ma_cargo","users.id","=","ma_cargo.id_funcionario")->select("users.id", DB::raw(" CONCAT(users.name, ' ', users.apellido, CASE WHEN ma_cargo.nombre IS NULL THEN '' ELSE ' [' END, IFNULL(ma_cargo.nombre, ' '), CASE WHEN ma_cargo.nombre IS NULL THEN '' ELSE ']' END )  as full_name"))
        ->whereIn('users.id', $arrayUsers);
    }

    public static function getJefatura($id_funcionario){
        return Cargo::whereIn('id', function($q) use($id_funcionario){
                                $q->from('ma_cargo')->select('id_jefatura')->where('id_funcionario', $id_funcionario);
                        })->select('id_funcionario')->get();
    }

    public static function getAdminEmpresa($id_empresa){
        return User::where('perfil',2)->where('empresa_id',$id_empresa)->where('id','!=',auth()->id())->select('id');
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


    public function getFechaInicioAttribute($fecha_inicio){
        if($fecha_inicio)
            return Carbon::parse($fecha_inicio)->format('d-m-Y');
    }
    public function getFechaNacimientoAttribute($fecha_nacimiento){
        if($fecha_nacimiento)
            return Carbon::parse($fecha_nacimiento)->format('d-m-Y');
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
