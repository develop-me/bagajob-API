<?php

use Illuminate\Database\Seeder;
use App\Job;
use App\Interview;

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
            $job->interviews()->saveMany(factory(Interview::class,2)->make());
        });
    }
}
