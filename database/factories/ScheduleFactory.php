<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Schedule;
use Faker\Generator as Faker;

$factory->define(Schedule::class, function (Faker $faker) {
//    $time_start = $faker->time($format = 'H');
//    if ($time_start == '23') {
//        $time_end = '00';
//    } else {
//        $time_end = (integer)$time_start + 1;
//    }

    $hour_start = rand(10, 20);
    $hour_end = $hour_start + 1;

    $minute_start = rand(0, 1) ? '00' : '30';
    $minute_end = rand(0, 1) ? '00' : '30';

    return [
        'weekday_id' => $faker->numberBetween($min = 1, $max = 7),
        'start' => $hour_start.':'.$minute_start,
        'end' => $hour_end.':'.$minute_end,
        'classroom' => $faker->numberBetween($min = 100, $max = 320),
    ];
});
