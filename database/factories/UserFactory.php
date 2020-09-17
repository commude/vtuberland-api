<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    $manufacturer = $faker->boolean(50) ? 'Samsung': 'Apple';
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => 'password', // password
        'remember_token' => Str::random(10),
        'device_uuid' => Str::random(121),
        'os' => $manufacturer == 'Samusng' ? 'android' : 'iOS',
        'manufacturer' => $manufacturer
    ];
});
