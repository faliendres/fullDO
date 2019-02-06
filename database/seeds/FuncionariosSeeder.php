<?php

use Illuminate\Database\Seeder;
use App\Cargo;
use App\Funcionario;
use Faker\Factory as Faker;

class FuncionariosSeeder extends Seeder
{
	/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0');
		DB::table('ma_funcionario')->truncate();
		$faker = Faker::create();
		Funcionario::query()->delete();
		for ($i=0; $i < 5; $i++) {
		    \DB::table('ma_funcionario')->insert(array(
		           'nombre' => $faker->firstName,
		           'apellido'  => $faker->lastName,
		           'foto'  => $faker->unique()->randomElement(['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','64-1.jpg','64-2.jpg']) 
		    ));
		}

		
		DB::table('ma_cargo')->truncate();
		$cargos = [
					[	'nombre' => 'Gerente General',
						'id_empresa' => 1,
						'area' => 'Gerencia General',
						'id_funcionario' => 1,
						'id_jefatura' => null,
						'estado'=>1
					],
					[	'nombre' => 'Gerente Comercial',
						'id_empresa' => 1,
						'area' => 'Gerencia Comercial',
						'id_jefatura' => 1,
						'estado' => 1
					],
					[	'nombre' => 'Gerente TI',
						'id_empresa' => 1,
						'area' => 'TI',
						'id_funcionario' => 2,
						'id_jefatura' => 1,
						'estado' => 1
					],
					[	'nombre' => 'Ingeniero Experto',
						'id_empresa' => 1,
						'area' => 'TI',
						'id_funcionario' => 4,
						'id_jefatura' => 3,
						'estado' => 1
					],
					[	'nombre' => 'Ingeniero Experto II',
						'id_empresa' => 1,
						'area' => 'TI',
						'id_jefatura' => 3,
						'estado' => 1
					],
					[	'nombre' => 'Gerente Finanzas',
						'id_empresa' => 1,
						'area' => 'Finanzas',
						'id_funcionario' => 3,
						'id_jefatura' => 1,
						'estado' => 1
					],
					[	'nombre' => 'Gerente RRHH',
						'id_empresa' => 1,
						'area' => 'Recursos Humanos',
						'id_jefatura' => 1,
						'estado' => 1
					],
					[	'nombre' => 'Gerente Administración',
						'id_empresa' => 1,
						'area' => 'Administración',
						'id_funcionario' => 5,
						'id_jefatura' => 1,
						'estado' => 1
					],
					[	'nombre' => 'Gerente de Riesgo',
						'id_empresa' => 1,
						'area' => 'Riesgo',
						'id_jefatura' => 1,
						'estado' => 1
					]
				];
		foreach ($cargos as $cargo){
            $s= Cargo::firstOrNew($cargo);
            if(!$s->exists){
                $s->save();
            }
        }
	}
}
