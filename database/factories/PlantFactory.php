<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Plant;
use Faker\Generator as Faker;

$factory->define(Plant::class, function (Faker $faker) {
    return [
        'commonName' => $faker->name,
        'division' => $faker->name,
        'class' => $faker->name,
        'order' => $faker->name,
        'family' => $faker->name,
        'genus' => $faker->name,
        'species' => $faker->name,
        'variety' => $faker->name
    ];
});
