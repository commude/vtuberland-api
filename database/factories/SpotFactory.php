<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Spot;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Collection;

$factory->define(Spot::class, function (Faker $faker) {
    $location = new Collection();

    for($i = 0; $i < $faker->numberBetween(1,5); $i++){
        $location->add([
            'longitude' => $faker->longitude,
            'latitude' => $faker->latitude
        ]);
    }

    return [
        'beacon_id' => $faker->uuid,
        'content' => $faker->realText(100),
        'location' => json_encode($location->toArray()),
    ];
});
