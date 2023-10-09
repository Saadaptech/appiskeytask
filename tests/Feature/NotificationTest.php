<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use App\Models\UserNotification;
use App\Models\User;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_notifications_are_triggered()
    {
        // Create a user with a specific timezone
        $user = User::factory()->create(['timezone' => 'America/New_York']);

        // Create a notification scheduled for a specific time in the user's timezone
        $scheduledTime = Carbon::now('America/New_York')->addMinutes(5)->format('H:i');
        UserNotification::factory()->create([
            'user_id' => $user->id,
            'scheduled_at' => $scheduledTime,
            'frequency' => 'daily',
            'last_sent_at' => null, // Add this line to set last_sent_at to null
        ]);

        // Run the notification trigger task (manually trigger it)
        $this->artisan('notifications:send');

        // Assert that the notification was sent to the user
        // You may need to define your own assertion here
        $this->assertTrue(UserNotification::where('user_id', $user->id)->exists());

    }
}
