<?php

use Illuminate\Database\Seeder;
use App\ApplicationNote;
use App\Job;

class AppNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // loop over all jobs and add 2 notes
        Job::all()->each(function ($job) {
            $job->notes()->saveMany(factory(ApplicationNote::class,2)->make());
        });
    }
}
