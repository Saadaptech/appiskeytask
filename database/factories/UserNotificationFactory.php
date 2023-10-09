<?php 

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserNotification;

class UserNotificationFactory extends Factory
{
    protected $model = UserNotification::class;

    public function definition()
    {
        return [
            // Define your factory attributes here
            'user_id' => $this->faker->numberBetween(1, 20),
            'scheduled_at' => $this->faker->time('H:i'),
            'frequency' => $this->faker->randomElement(['daily', 'weekly', 'monthly']),
        ];
    }
}

