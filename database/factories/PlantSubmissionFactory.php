<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PlantSubmission;
use Faker\Generator as Faker;

$factory->define(PlantSubmission::class, function (Faker $faker) {
    return [
        'userId' => 1,
        'plantId' => 1,
        'latitude' => 1,
        'longitude' => 1,
        'title' => $faker->name,
        'description' => $faker->name,
        'upvotes' => 0
    ];
});
