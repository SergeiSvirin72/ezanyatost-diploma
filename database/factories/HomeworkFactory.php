<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Homework;
use Faker\Generator as Faker;

$factory->define(Homework::class, function (Faker $faker) {
    //$date = new DateTime('2020-'.$faker->date($format = 'm-d'));
    return [
        'date' => $faker->dateTimeBetween($startDate = '2019-09-01', $endDate = '2020-06-20'),
        'value' => $faker->paragraph($nbSentences = 1, $variableNbSentences = true),
    ];
});
