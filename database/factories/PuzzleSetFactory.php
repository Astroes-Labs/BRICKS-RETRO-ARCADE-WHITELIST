<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */class PuzzleSetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->slug,
            'rarity' => $this->faker->numberBetween(1, 5),
            'whitelist_reward' => $this->faker->numberBetween(1, 3),
            'is_active' => true,
        ];
    }
}