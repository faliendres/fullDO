<?php

if (!function_exists('menu')) {

    function menu()
    {
        $menu = \App\Menu::query()->whereNull("parent_id");
        return $menu->get();
    }
}

if (!function_exists('re')) {

    function menu()
    {
        request()->routeIs();
        $menu = \App\Menu::query()->whereNull("parent_id");
        return $menu->get();
    }
}
