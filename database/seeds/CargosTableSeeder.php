<?php

use Illuminate\Database\Seeder;
use App\Cargo;
use Faker\Factory as Faker;

class CargosTableSeeder extends Seeder
{
	/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
		DB::table('ma_cargo')->truncate();
		$cargos = [
					[	'nombre' => 'Gerente General',
						'id_gerencia' => 1,
						'area' => 'Gerencia General',
						'id_jefatura' => null,
						'estado'=>1
					],
					[	'nombre' => 'Gerente Comercial',
						'id_gerencia' => 1,
						'area' => 'Gerencia Comercial',
						'id_jefatura' => 1,
						'estado' => 1
					],
					[	'nombre' => 'Gerente TI',
						'id_gerencia' => 1,
						'area' => 'TI',
						'id_jefatura' => 1,
						'estado' => 1
					],
					[	'nombre' => 'Ingeniero Experto',
						'id_gerencia' => 1,
						'area' => 'TI',
						'id_jefatura' => 3,
						'estado' => 1
					],
					[	'nombre' => 'Ingeniero Experto II',
						'id_gerencia' => 1,
						'area' => 'TI',
						'id_jefatura' => 3,
						'estado' => 1
					],
					[	'nombre' => 'Gerente Finanzas',
						'id_gerencia' => 1,
						'area' => 'Finanzas',
						'id_jefatura' => 1,
						'estado' => 1
					],
					[	'nombre' => 'Gerente RRHH',
						'id_gerencia' => 2,
						'area' => 'Recursos Humanos',
                        'estado' => 1
					],
					[	'nombre' => 'Gerente Administración',
						'id_gerencia' => 1,
						'area' => 'Administración',
						'id_jefatura' => 1,
						'estado' => 1
					],
					[	'nombre' => 'Gerente de Riesgo',
						'id_gerencia' => 1,
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
