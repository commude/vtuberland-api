<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Character;
use Faker\Generator as Faker;

$factory->define(Character::class, function (Faker $faker) {
    return [
        'content' => $faker->realText(50),
    ];
});
