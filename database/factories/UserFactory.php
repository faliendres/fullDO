<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {

    $holding = \App\Holding::query()->inRandomOrder()->first();

    $empresa = null;
    $gerencia = null;
    if ($faker->boolean) {
        $empresa = \App\Empresa::query()
            ->where("id_holding", $holding->id)
            ->inRandomOrder()->first();
        if ($empresa && $faker->boolean) {
            $gerencia = \App\Gerencia::query()
                ->where("id_empresa", $empresa->id)
                ->inRandomOrder()->first();
        }
    }
    return [
        'name' => $faker->name,
        "apellido" => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'usuario_creacion'=> \App\User::first()->id,
        'perfil'=> 1,
        'rut'=> $faker->numerify("#######")
    ];
});
