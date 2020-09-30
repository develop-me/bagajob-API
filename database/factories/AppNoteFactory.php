<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ApplicationNote;
use Faker\Generator as Faker;

$factory->define(ApplicationNote::class, function (Faker $faker) {
    return [
        'date' => $faker->date(),
        'data' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true)
    ];
});
