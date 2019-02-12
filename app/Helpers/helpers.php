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

    function image_asset($type = "avatar", $file = "")
    {
        $base = config("filesystems.disks.$type.url");
        if (!$file)
            return $base;
        return "$base/$file";
    }
}
