<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        $faker = Faker::create();
        User::query()->delete();

        // SUPER ADMIN
        \DB::table('users')->insert(array(
               'name' => 'Super',
               'apellido'  => 'Admin',
               'rut'  => '11',
               'email' => 'superadmin@gmail.com',
               'password' => bcrypt('123456'),
               'foto'  => $faker->unique()->randomElement(['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','64-1.jpg','64-2.jpg']),
               'password_changed_at' => date('Y-m-d H:i:s'),
        ));
        // HOLDING
        \DB::table('users')->insert(array(
               'name' => 'Holding',
               'apellido'  => 'Admin',
               'rut'  => '22',
               'email' => 'holding@gmail.com',
               'password' => bcrypt('123456'),
               'perfil' => 1,
               'foto'  => $faker->unique()->randomElement(['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','64-1.jpg','64-2.jpg']),
               'gerencia_id'  => 1,
               'empresa_id'  => 1,
               'holding_id'  => 1,
               'password_changed_at' => date('Y-m-d H:i:s'),
        ));
        // EMPRESARIAL
        \DB::table('users')->insert(array(
               'name' => 'Empresarial',
               'apellido'  => 'Admin',
               'rut'  => '33',
               'email' => 'empresarial@gmail.com',
               'password' => bcrypt('123456'),
               'perfil' => 2,
               'foto'  => $faker->unique()->randomElement(['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','64-1.jpg','64-2.jpg']),
               'gerencia_id'  => 1,
               'empresa_id'  => 1,
               'holding_id'  => 1,
               'password_changed_at' => date('Y-m-d H:i:s'),
        ));
        // GERENCIAL
        \DB::table('users')->insert(array(
               'name' => 'Gerencial',
               'apellido'  => 'Admin',
               'rut'  => '44',
               'email' => 'gerencial@gmail.com',
               'password' => bcrypt('123456'),
               'perfil' => 3,
               'foto'  => $faker->unique()->randomElement(['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','64-1.jpg','64-2.jpg']),
               'gerencia_id'  => 1,
               'empresa_id'  => 1,
               'holding_id'  => 1,
               'password_changed_at' => date('Y-m-d H:i:s'),
        ));
        // FUNCIONAL
        \DB::table('users')->insert(array(
               'name' => 'Funcional',
               'apellido'  => 'Admin',
               'rut'  => '55',
               'email' => 'funcional@gmail.com',
               'password' => bcrypt('123456'),
               'perfil' => 4,
               'foto'  => $faker->unique()->randomElement(['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','64-1.jpg','64-2.jpg']),
               'gerencia_id'  => 1,
               'empresa_id'  => 1,
               'holding_id'  => 1,
               'password_changed_at' => date('Y-m-d H:i:s'),
        ));

        for ($i=0; $i < 3; $i++) { 
            \DB::table('users')->insert(array(
                 'name' => $faker->firstName,
                 'apellido'  => $faker->lastName,
                 'rut'  => $faker->numberBetween($min = 1000, $max = 9000),
                 'email' => $faker->email,
                 'password' => bcrypt('123456'),
                 'perfil' => 4,
                 'foto'  => $faker->unique()->randomElement(['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','64-1.jpg','64-2.jpg']),
                 'gerencia_id'  => $faker->randomDigit,
                 'empresa_id'  => 1,
                 'holding_id'  => 1,
                 'password_changed_at' => date('Y-m-d H:i:s'),
                 'fecha_inicio' => $faker->date('Y-m-d H:i:s', 'now')
          ));
        }

    }
}
