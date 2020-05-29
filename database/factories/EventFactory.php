<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    //$date = new DateTime('2020-'.$faker->date($format = 'm-d'));
    return [
        'name' => $faker->paragraph($nbSentences = 1, $variableNbSentences = true),
        'content' => $faker->text($maxNbChars = rand(2000, 2500)),
        'date' => $faker->dateTimeBetween($startDate = '2019-09-01', $endDate = '2020-06-20'),
    ];
});
