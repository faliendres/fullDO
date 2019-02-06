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
            "order"=>0
        ]);
        $admin=Menu::create( [
            "title"=>"Admin",
            "order"=>1
        ]);
        $users=Menu::create( [
            "parent_id"=>$admin->id,
            "title"=>"Users",
            "order"=>0
        ]);
        Menu::create( [
            "parent_id"=>$users->id,
            "title"=>"Listado",
            "route"=>"users.index",
            "order"=>0
        ]);

    }
}
