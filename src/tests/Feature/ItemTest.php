<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\PaymentMethod;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\PaymentMethodsTableSeeder;


class ItemTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase , WithFaker;

     /** @test */
    public function it_displays_all_items()
    {

        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        Item::factory()->count(3)->create();

        $response = $this->get('/');
        $response->assertStatus(200);

        $items = Item::all();
        foreach ($items as $item) {
            $response->assertSee($item->name);
            $response->assertSee($item->thumbnail);
        }
    }
     /** @test */
    public function Sold_label_is_displayed_for_purchased_items()
{
    Artisan::call('migrate:refresh');
    Artisan::call('db:seed');

    $user = User::factory()->create();
    $this->actingAs($user);

    $purchasedItem = Item::factory()->create();
    $paymentMethod = PaymentMethod::first();

    Purchase::factory()->create([
        'item_id' => $purchasedItem->id,
        'user_id' => $user->id,
        'payment_method_id' => $paymentMethod->id,
        'post_code' => $this->faker->postcode(),
        'address' => $this->faker->address(),
        'building' => $this->faker->optional()->secondaryAddress(),
    ]);

    $unpurchasedItem = Item::factory()->create();

    $response = $this->get('/');

    $response->assertSee('Sold');
    $response->assertSee($purchasedItem->name);

    $response->assertDontSee($unpurchasedItem->name . ' Sold');
    }


     /** @test */
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

    $response->assertDontSeeText($userItem->name);
    $response->assertDontSee($userItem->thumbnail);

    $response->assertSeeText($otherItem->name);
    $response->assertSee($otherItem->thumbnail);
}

}