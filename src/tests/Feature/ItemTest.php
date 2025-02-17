<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use Database\Seeders\ConditionsTableSeeder;

class ItemTest extends TestCase
{
    /**
     * A basic feature test example.
     */

     /** @test */
    public function it_displays_all_items()
    {
        $this->seed(ConditionsTableSeeder::class);
        Item::factory()->count(3)->create();

        $response = $this->get('/');
        $response->assertStatus(200);

        $items = Item::all();
        foreach ($items as $item) {
            $response->assertSee($item->name);
            $response->assertSee($item->thumbnail);
        }
    }

    public function Sold_label_is_displayed_for_purchased_items()
{
    $this->seed(PaymentMethodsTableSeeder::class);
    $purchasedItem = Item::factory()->create();
    Purchase::factory()->create([
        'item_id' => $purchasedItem->id,
        'user_id' => User::factory()->create()->id,
        'payment_method_id' => PaymentMethod::factory()->create()->id,
        'post_code' => $this->faker->postcode(),
        'address' => $this->faker->address(),
        'building' => $this->faker->optional()->secondaryAddress(),
    ]);

    $unpurchasedItem = Item::factory()->create();

    $response = $this->get('/');

    $response->assertSee('Sold');

    $response->assertDontSee($unpurchasedItem->name . ' Sold');
    }

    public function user_items_are_hidden_from_themselves()
{

    $user = User::factory()->create();

    $userItem = Item::factory()->create([
        'user_id' => $user->id,
    ]);

    $otherItem = Item::factory()->create([
        'user_id' => User::factory()->create()->id,
    ]);

    $response = $this->actingAs($user)->get('/');

    $response->assertDontSee($userItem->name);
    $response->assertDontSee($userItem->thumbnail);

    $response->assertSee($otherItem->name);
    $response->assertSee($otherItem->thumbnail);
}

}