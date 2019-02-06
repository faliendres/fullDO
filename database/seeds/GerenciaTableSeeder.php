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
        $empresa = [1,2,3];

        foreach (range(1,3) as $index) {
            $empresa_id = $faker->randomElement($empresa);
            DB::table('ma_gerencia')->insert([
                'nombre' => $faker->name,
                'descripcion' => $faker->paragraph(),
                'color' => $faker->colorName,
                'fecha_creacion' => $faker->dateTime(),
                'usuario_creacion' => $faker->firstName,
                'id_empresa' => $empresa_id,
            ]);
        }



    }
}
