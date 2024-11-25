<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'name' => fake()->name(),
            'completed_at' => now(),
        ];
    }

    protected $model = Todo::class;

    public function incomplete(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed_at' => null,
        ]);
    }
}
