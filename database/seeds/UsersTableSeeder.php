<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrNew(["email" => "root@fulldo.com"]);
        if (!$user->exists) {
            $user->fill([
                'name' => "ROOT USER",
                'email_verified_at' => now(),
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'remember_token' => str_random(10),
            ])->save();
        }
    }
}
