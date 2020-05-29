<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Organisation;
use Faker\Generator as Faker;

$factory->define(Organisation::class, function (Faker $faker) {
    $name = $faker->company;
    $address = $faker->address;
    $phone = $faker->phoneNumber;
    $reception = $faker->time($format = 'H');
    $img = 'https://loremflickr.com/'
        .$faker->numberBetween($min = 300, $max = 320)
        .'/'
        .$faker->numberBetween($min = 220, $max = 240)
        .'/dog';
    return [
        'full_name' => $name,
        'short_name' => $name,
        //'director' => $faker->name,
        'reception' => $reception.':00 - '.($reception + 2).':00',
        'legal_address' => $address,
        'actual_address' => $address,
        'phone' => $phone,
        'email' => $faker->companyEmail,
        'website' => $faker->domainName,
        'is_school' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
