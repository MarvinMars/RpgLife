<?php

namespace Database\Factories;

use App\Enums\QuestStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quest>
 */
class QuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = Arr::random(QuestStatus::toArray());
        $is_completed = $status === QuestStatus::COMPLETED->value;

        return [
            'name' => fake()->name(),
            'slug' => fake()->unique()->slug(3),
            'xp' => fake()->numberBetween(0, 300),
            'status' => $status,
            'is_rewarded' => $is_completed,
            'description' => fake()->paragraph(),
            'user_id' => User::factory(),
            'completed_at' => $is_completed ? $this->faker->dateTimeBetween('-3 months', 'now') : null,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
