<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'familyName' => fake()->lastName(),
            'nationalCode' => fake()->unique()->numberBetween(1, 11111111111111111),
            'personalCode' => fake()->unique()->numberBetween(1, 11111111),
            'storeId' => fake()->numerify('#'),
            'mobile' => fake()->unique()->numerify('#############'),
            'role' => fake()->numerify('#'),
            'status' => fake()->numerify('#'),
            'password' => fake()->password(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
