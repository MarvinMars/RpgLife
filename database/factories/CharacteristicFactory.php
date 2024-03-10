<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Characteristic>
 */
class CharacteristicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
	    return [
		    'name' => fake()->name(),
		    'slug' => fake()->unique()->slug(3),
		    'description' => fake()->paragraph(),
		    'user_id' => User::factory(),
	    ];
    }
}
