<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $timezones = [
            'America/New_York',
            'Asia/Tokyo',
            // Add more timezones as needed
        ];

        foreach (\DB::table('users')->get() as $user) {
            foreach (range(1, 20) as $index) {
                $scheduledTime = $faker->time('H:i');
                $frequency = $faker->randomElement(['daily', 'weekly', 'monthly', 'custom']);

                // Convert scheduled time to the user's local time zone
                $timezone = $user->timezone;
                $scheduledAt = Carbon::createFromFormat('H:i', $scheduledTime, $timezone);

                \DB::table('user_notifications')->insert([
                    'user_id' => $user->id,
                    'scheduled_at' => $scheduledAt->format('H:i'),
                    'frequency' => $frequency,
                ]);
            }
        }
    }
}
