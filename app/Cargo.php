<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'ma_cargo';

    public function gerencia()
    {
        return $this->belongsTo(Gerencia::class, "id_gerencia", "id");
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            Cargo::query()
                ->where("id_funcionario", $model->id_funcionario)->update(["id_funcionario" => null]);
        });
        self::saved(function ($model) {
            $user = User::find($model->id_funcionario);
            if ($user) {
                $user->updated_at=Carbon::now();
                $user->update();
            }
        });

        static::updating(function ($model) {
            Cargo::query()
                ->where("id", "<>", $model->id)
                ->where("id_funcionario", $model->id_funcionario)->update(["id_funcionario" => null]);
        });
        static::updated(function ($model) {
            $user = User::find($model->id_funcionario);
            if ($user) {
                $user->updated_at=Carbon::now();
                $user->update();
            }
        });

    }

}
