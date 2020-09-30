<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Interview;

class InterviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // loop over jobs and add 2 interviews
        Job::all()->each(function ($job) {
            $job->interviews()->saveMany(Interview::factory()->count(2)->make());
        });
    }
}
