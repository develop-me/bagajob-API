<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {
    return [
        'job_title' => substr($faker->jobTitle(), 0, 50),
        'company' => $faker->company(),
        'stage' => 1,
        'description' => $faker->sentences($nb = 3, $asText = true),
        'salary' => $faker->numberBetween($min = 16000, $max = 60000),
        'closing_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 years', $timezone = 'GMT'),
        'location' => $faker->city(),
    ];
});
