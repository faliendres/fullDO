<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::query()->delete();
        Menu::create([
            "title" => "Organigrama",
            "route" => "home",
            "permissions" => 4,
            "icon" => "fa fa-sitemap",
            "order" => 0
        ]);
        $admin = Menu::create([
            "title" => "Admin",
            "permissions" => 3,
            "order" => 1
        ]);
        $users = Menu::create([
            "parent_id" => $admin->id,
            "title" => "Usuarios",
            "permissions" => 3,
            "icon" => "fa fa-users",
            "order" => 0
        ]);
        Menu::create([
            "parent_id" => $users->id,
            "title" => "Listado",
            "route" => "users.index",
            "order" => 0
        ]);
        $holdings = Menu::create([
            "parent_id" => $admin->id,
            "title" => "Holdings",
            "permissions" => 0,
            "icon" => "fa fa-university",
            "order" => 1
        ]);
        Menu::create([
            "parent_id" => $holdings->id,
            "title" => "Listado",
            "route" => "holdings.index",
            "order" => 0
        ]);
        $holdings = Menu::create([
            "parent_id" => $admin->id,
            "title" => "Empresas",
            "permissions" => 1,
            "icon" => "fa fa-building-o",
            "order" => 2
        ]);
        Menu::create([
            "parent_id" => $holdings->id,
            "title" => "Listado",
            "route" => "empresas.index",
            "order" => 0
        ]);
        $holdings = Menu::create([
            "parent_id" => $admin->id,
            "title" => "Gerencias",
            "permissions" => 1,
            "icon" => "fa fa-group",
            "order" => 2
        ]);
        Menu::create([
            "parent_id" => $holdings->id,
            "title" => "Listado",
            "route" => "gerencias.index",
            "order" => 0
        ]);

    }
}
