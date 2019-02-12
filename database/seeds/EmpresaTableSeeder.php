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
        for($i=1; $i<3; $i++) {
            foreach (range(1,3) as $index) {
                DB::table('ma_empresa')->insert([
                    'nombre' => "Empresa ".$faker->company,
                    'rut' => $faker->numerify("##########"),
                    'descripcion' => $faker->paragraph(),
                    'logo' => $faker->imageUrl(),
                    'color' => $faker->colorName,
                    'fecha_creacion' => $faker->dateTime(),
                    'desde' => $faker->dateTime(),
                    'hasta' => $faker->dateTime(),
                    'id_holding' => $i,
                ]);
            }
        }       
    }
}
