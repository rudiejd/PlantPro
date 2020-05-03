<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'userId' => 1,
        'plantSubmissionId' => 1,
        'body' => $faker->name,
        'parentId' => 0,
        'upvotes' => 0
    ];
});
