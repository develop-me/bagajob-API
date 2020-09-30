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
        // create 10 users, for each user create and asssociate 10 jobs with that user
        factory(App\User::class, 10)->create()->each(function ($user)
        {
            $user->jobs()
                ->saveMany(
                    factory(App\Job::class, 10)->make());
        });
    }
}
