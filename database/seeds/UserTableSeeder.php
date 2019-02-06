<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::firstOrNew([
            'email'    => 'superadmin@gmail.com',
        ]);
        if(!$user->exists)
        $user->fill(
            [
                'name'     => 'Super',
                'apellido'     => 'Admin',
                'password' => bcrypt('123456')
            ]
        )->save();

        $users = factory(User::class,5)->make();
        foreach ($users as $user) {
            $user->save();
        }
    }
}