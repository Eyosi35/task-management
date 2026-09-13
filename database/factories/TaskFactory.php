<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->User::factory(),
            'title' => fake()->sentence(5),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement([
                'pending', 'in_progress', 'completed'
            ]),
            'due_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),;
        ];
    }
}
