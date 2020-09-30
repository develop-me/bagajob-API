<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Interview;
use Faker\Generator as Faker;

$factory->define(Interview::class, function (Faker $faker) {
    return [
        'interview_date' => $faker->date(),
        'format' => $faker->randomElement($array = array ('online_testing','telephone', 'video_call', 'in_person',)),
        'interviewer' => $faker->name(),
        'notes' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true)
    ];
});
