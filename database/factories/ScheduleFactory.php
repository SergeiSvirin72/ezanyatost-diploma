<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Schedule;
use Faker\Generator as Faker;

$factory->define(Schedule::class, function (Faker $faker) {
    $time = $faker->time($format = 'H');
    return [
        'weekday' => $faker->numberBetween($min = 0, $max = 6),
        'start' => $time.':00:00',
        'end' => ($time + 2).':00:00',
        'classroom' => $faker->numberBetween($min = 100, $max = 320),
    ];
});
