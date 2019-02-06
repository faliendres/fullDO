<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;

class EmpresaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $holding = [1,2,3];

        foreach (range(1,3) as $index) {
            $holding_id = $faker->randomElement($holding);
            DB::table('ma_empresa')->insert([
                'nombre' => $faker->company,
                'rut' => $faker->numerify("##########"),
                'descripcion' => $faker->paragraph(),
                'logo' => $faker->imageUrl(),
                'color' => $faker->colorName,
                'fecha_creacion' => $faker->dateTime(),
                'desde' => $faker->dateTime(),
                'hasta' => $faker->dateTime(),
                'id_holding' => $holding_id,
            ]);
        }

    }
}
