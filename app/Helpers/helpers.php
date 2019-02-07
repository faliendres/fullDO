<?php

if (!function_exists('menu')) {

    function menu()
    {
        $menu = \App\Menu::query()->whereNull("parent_id");
        return $menu->get();
    }
}


if (!function_exists('toOptions')) {

    function toOptions(\Illuminate\Database\Eloquent\Builder $query, $key = "id", $value = "nombre", $selected = null)
    {
        $options = $query->get()->map(function ($item) use ($key, $value, $selected) {
            return
                [
                    "text" => $item->$value,
                    "selected" => ($item->$key == $selected),
                    "id" => $item->$key
                ];
        });
//        dd($options);
        return $options;
    }
}

