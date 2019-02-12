<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class HoldingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,2) as $index) {
            DB::table('ma_holding')->insert([
                'nombre' => "Holding ".$faker->company,
                'descripcion' => $faker->paragraph(),
                'logo' => $faker->imageUrl(),
                'color' => $faker->colorName,
            ]);
        }
    }
}
