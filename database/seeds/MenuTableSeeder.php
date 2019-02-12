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
        Menu::create( [
            "title"=>"Organigrama",
            "route"=>"home",
            "icon"=>"fa fa-sitemap",
            "order"=>0
        ]);
        $admin=Menu::create( [
            "title"=>"Admin",
            "order"=>1
        ]);
        $users=Menu::create( [
            "parent_id"=>$admin->id,
            "title"=>"Usuarios",
            "icon"=>"fa fa-users",
            "order"=>0
        ]);
        Menu::create( [
            "parent_id"=>$users->id,
            "title"=>"Listado",
            "route"=>"users.index",
            "order"=>0
        ]);
        $holdings=Menu::create( [
            "parent_id"=>$admin->id,
            "title"=>"Holdings",
            "icon"=>"fa fa-university",
            "order"=>0
        ]);
        Menu::create( [
            "parent_id"=>$holdings->id,
            "title"=>"Listado",
            "route"=>"holdings.index",
            "order"=>0
        ]);

    }
}
