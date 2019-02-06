<?php

if (!function_exists('menu')) {

    function menu()
    {
        $menu = \App\Menu::query()->whereNull("parent_id");
        return $menu->get();
    }
}
