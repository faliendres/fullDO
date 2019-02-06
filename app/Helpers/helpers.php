<?php

if (!function_exists('menu')) {

    function menu()
    {
        $menu = \App\Menu::query()->whereNull("parent_id");
//        dd($menu->toSql());
        return $menu->get();
    }
}
