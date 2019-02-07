<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;

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

        foreach (range(1,3) as $index) {
            DB::table('ma_holding')->insert([
                'nombre' => " Holding ".$faker->company,
                'descripcion' => $faker->paragraph(),
                'logo' => $faker->imageUrl(),
                'color' => $faker->colorName,
                'fecha_creacion' => $faker->dateTime(),
            ]);
        }


    }
}
