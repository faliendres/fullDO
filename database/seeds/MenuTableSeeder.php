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
            "title" => "Administracion",
            "permissions" => 3,
            "order" => 1
        ]);
        $users = Menu::create([
            "title" => "Usuarios",
            "route" => "users.index",
            "permissions" => 3,
            "icon" => "fa fa-users",
            "order" => 2
        ]);
        
        $admin_estruc = Menu::create([
            "parent_id" => $admin->id,
            "title" => "Estructura",
            "permissions" => 3,
            "icon" => "fa fa-server",
            "order" => 4
        ]);
        $holdings = Menu::create([
            "parent_id" => $admin_estruc->id,
            "title" => "Holdings",
            "route" => "holdings.index",
            "permissions" => 0,
            "icon" => "fa fa-university",
            "order" => 1
        ]);
        $empresas = Menu::create([
            "parent_id" => $admin_estruc->id,
            "title" => "Empresas",
            "route" => "empresas.index",
            "permissions" => 1,
            "icon" => "fa fa-building-o",
            "order" => 2
        ]);
        $gerencias = Menu::create([
            "parent_id" => $admin_estruc->id,
            "title" => "Gerencias",
            "route" => "gerencias.index",
            "permissions" => 2,
            "icon" => "fa fa-group",
            "order" => 2
        ]);      
        $cargos = Menu::create([
            "parent_id" => $admin_estruc->id,
            "title" => "Cargos",
            "route" => "cargos.index",
            "permissions" => 3,
            "icon" => "fa fa-laptop",
            "order" => 3
        ]);
        /*$cargos = Menu::create([
            "parent_id" => $admin_estruc->id,
            "title" => "Solicitudes",
            "route" => "solicitudes.index",
            "permissions" => 3,
            "icon" => "fa fa-file-text-o",
            "order" => 4
        ]);*/
    }
}
