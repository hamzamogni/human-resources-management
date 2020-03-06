<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Meeting;
use Faker\Generator as Faker;

$factory->define(Meeting::class, function (Faker $faker) {
    return [
        "cell_id" => DB::table("cells")->inRandomOrder()->first()->id,
        "meeting_date" => $faker->date(),
        "meeting_time" => $faker->time(),
    ];
});
