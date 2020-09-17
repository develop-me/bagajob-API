<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {
    return [
        'title' => substr($faker->jobTitle(), 0, 50),
        'company' => $faker->company(),
        'active' => $faker->boolean(),
        'stage' => $faker->randomElement($array = array(1,2,3,4)),
        'description' => $faker->sentences($nb = 3, $asText = true),
        'salary' => $faker->numberBetween($min = 16000, $max = 60000),
        'closing_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 years', $timezone = 'GMT'),
        'date_applied' => $faker->dateTime($max = 'now'),
        'location' => $faker->city(),
    ];
});
