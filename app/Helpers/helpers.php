<?php

if (!function_exists('menu')) {

    function menu()
    {
        $menu = \App\Menu::query()->whereNull("parent_id");
        return $menu->get();
    }
}


if (!function_exists('toOptions')) {

    function toOptions(\Illuminate\Database\Eloquent\Builder $query, $key = "id", $value = "nombre")
    {
        $options = $query->get()->map(function ($item) use ($key, $value) {
            return
                [
                    "text" => $item->$value,
                    "id" => $item->$key
                ];
        });
        return $options;
    }
}
if (!function_exists('toOption')) {

    function toOption($object, $key = "id", $value = "nombre")
    {
        if ($object)
            return
                [
                    "text" => $object->$value,
                    "id" => $object->$key
                ];
    }
}

if (!function_exists('image_asset')) {

    function image_asset($type = "users", $file = "")
    {
        if (substr($file, 0, 4 ) === "http")
            return $file;

        $base = config("filesystems.disks.$type.url");
        if (!$file)
            return $base;
        return "$base/$file";
    }
}

if (!function_exists('backButton')) {
    function backButton()
    {
        $back = session('back-btn',false);
        if ($back) {
            $route = request()->route();
            if($route->getName()=='perfil')
                return 0;
            $back = !\App\Menu::query()->where("route", $route->getName())->exists();
        }
        return $back;
    }
}