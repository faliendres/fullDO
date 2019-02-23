<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;

class GerenciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i=1; $i<7; $i++) {
            foreach (range(1,3) as $index) {
                DB::table('ma_gerencia')->insert([
                    'nombre' => $faker->jobTitle,
                    'descripcion' => $faker->paragraph(),
                    'color' => $faker->colorName,
                    'fecha_creacion' => $faker->dateTime(),
                    'usuario_creacion' => $faker->firstName,
                    'id_empresa' => $i,
                ]);
            }
        }
    }
}
