<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seeds our admin user
        User::factory()->create([
            'name'=> env('ADMIN_USER_NAME'),
            'email'=> env('ADMIN_USER_EMAIL'),
            'password'=> Hash::make(env('ADMIN_USER_PASSWORD'))
        ]);
    }
}
