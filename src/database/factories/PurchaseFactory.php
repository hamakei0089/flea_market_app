<?php

namespace Database\Factories;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Models\PaymentMethod;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Purchase::class;

    public function definition()
    {
        return [
            'item_id' => Item::factory(),
            'user_id' => User::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'post_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'building' => $this->faker->optional()->secondaryAddress(),
        ];
    }
}
