<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationNote;
use App\Models\Job;

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
            $job->notes()->saveMany(ApplicationNote::factory()->count(10)->make());
        });
    }
}
