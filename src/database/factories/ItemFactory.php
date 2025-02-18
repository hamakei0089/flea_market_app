<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'thumbnail' => $this->faker->imageUrl(200, 200),
            'price' => $this->faker->randomNumber(6),
            'description' => $this->faker->sentence,
            'user_id' => \App\Models\User::factory(),
            'condition_id' => $this->faker->numberBetween(1, 4),
        ];
    }
}
