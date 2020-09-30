<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Job;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 10 users, for each user create and asssociate 10 jobs with that user
        User::factory()->count(10)->create()->each(function ($user)
        {
            $user->jobs()
                ->saveMany(
                    Job::factory()->count(10)->make());
        });
    }
}
