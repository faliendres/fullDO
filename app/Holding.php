<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holding extends Model
{
    protected $table = "ma_holding";

    public static function query()
    {
        $query = (new static)->newQuery();
        $user = auth()->user();
        if ($user && $user->holding_id)
            $query = $query->where("id", $user->holding_id);
        return $query;

    }
}
