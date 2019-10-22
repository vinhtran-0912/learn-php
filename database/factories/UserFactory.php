<?php

use Faker\Generator as Faker;
use Faker\Factory as FakerJP;
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

$fakerJP = FakerJP::create('ja_JP');

$factory->define(App\User::class, function (Faker $faker) use($fakerJP) {
    return [
        'name' => $fakerJP->realText($maxNbChars = 20),
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
