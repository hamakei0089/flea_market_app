<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $faker = Faker::create();

        for ($i = 0; $i < 3; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'post_code' => $faker->regexify('[0-9]{3}-[0-9]{4}'),
                'address' => $faker->address,
                'building' => $faker->secondaryAddress,
                'thumbnail' => 'src/storage/app/public/profiles/human.jpeg',
                'is_profile_complete' => 1,
            ]);
        }
    }
}