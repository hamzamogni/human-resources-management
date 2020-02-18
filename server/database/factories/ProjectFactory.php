<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->userName,
        'description' => $faker->text(),
        "creation_date" => $faker->date(),
    ];
});
