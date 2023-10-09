<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // List of timezones
        $timezones = [
            'America/New_York',
            'Asia/Tokyo',
            // Add more timezones as needed
        ];

        foreach (range(1, 20) as $index) {
            $name = $faker->name;
            $timezone = $timezones[array_rand($timezones)];
            $created_at = Carbon::now()->subDays(rand(1, 365));
            $updated_at = Carbon::now()->subDays(rand(1, 365));

            \DB::table('users')->insert([
                'name' => $name,
                'timezone' => $timezone,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ]);
        }
    }
}
