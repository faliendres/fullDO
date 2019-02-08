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
               'rut'  => '5',
               'email' => 'superadmin@gmail.com',
               'password' => bcrypt('123456'),
               'foto'  => $faker->unique()->randomElement(['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','64-1.jpg','64-2.jpg']),
               'password_changed_at' => date('Y-m-d H:i:s'),
        ));

    }
}
