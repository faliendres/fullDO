<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    public $timestamps = false;
    protected $fillable = [
        "parent_id",
        "title",
        "route",
        "params",
        "url",
        "order",
        "permissions",
        "icon"
    ];

    protected static function boot()
    {
        parent::boot();

        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, "parent_id", "id");
    }

    public function subItems()
    {
        return $this->hasMany(Menu::class, "parent_id", "id");
    }

    public function target()
    {
        if ($this->_target)
            return $this->_target;
        if ($this->route) {
            if ($this->params)
                $this->params = json_decode($this->params);
            else $this->params = [];
            $this->_target = route($this->route, $this->params);
        }
        else
            $this->_target = $this->url;
        if (!$this->_target)
            $this->_target = '#';
        return $this->_target;
    }
}
