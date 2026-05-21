<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'description' => $this->faker->sentence(),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 week')->format('Y-m-d'),
            'priority' => $this->faker->randomElement(['high', 'medium', 'low']),
            'is_completed' => false,
        ];
    }
}
