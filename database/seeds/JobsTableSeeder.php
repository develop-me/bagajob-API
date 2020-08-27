<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 100) as $index) {

            DB::table('jobs')->insert([
                'job_title' => $faker->jobTitle(),
                'company' => $faker->company(),
                'stage' => 1,
                'description' => $faker->sentences($nb = 5, $asText = true),
                'salary' => $faker->numberBetween($min = 16000, $max = 60000),
                'closing_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 years', $timezone = 'GMT'),
                'location' => $faker->city(),
            ]);
        }

    }
}
