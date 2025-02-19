<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Purchase;
use App\Models\PaymentMethod;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\PaymentMethodsTableSeeder;

class MylistTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase , WithFaker;

    /** @test */
    public function only_favorited_items_are_displayed_on_my_list_page()
    {

        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        $user = User::factory()->create();
        $this->actingAs($user);

        $items = Item::factory()->count(5)->create();

        Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $items[0]->id,
        ]);
        Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $items[2]->id,
        ]);

        $response = $this->get('/?page=mylist');

        $response->assertStatus(200);
        $response->assertSeeText($items[0]->name);
        $response->assertSeeText($items[2]->name);

        $response->assertDontSeeText($items[1]->name);
        $response->assertDontSeeText($items[3]->name);
        $response->assertDontSeeText($items[4]->name);
    }

    /** @test */
    public function purchased_items_are_marked_as_sold_in_my_list_page()
    {

        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create(['name' => 'Test Item']);

        Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        Purchase::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'payment_method_id' =>  \App\Models\PaymentMethod::inRandomOrder()->first()->id,
            'post_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'building' => $this->faker->optional()->secondaryAddress(),
        ]);

        $response = $this->get('/?page=mylist');

        $response->assertStatus(200);

        $response->assertSeeText('Test Item');
        $response->assertSee('Sold');

    }
    /** @test */
    public function user_items_are_hidden_from_themselves()
    {

    Artisan::call('migrate:refresh');
    Artisan::call('db:seed');

    $user = User::factory()->create();

    $userItem = Item::factory()->create([
        'user_id' => $user->id,
    ]);

    Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $userItem->id,
        ]);

    $response = $this->actingAs($user)->get('/?page=mylist');

    $response->assertDontSee($userItem->name);
    $response->assertDontSee($userItem->thumbnail);
    }

    /** @test */
    public function no_items_are_displayed_on_my_list_page_for_unauthenticated_users()
    {
    $response = $this->get('/?page=mylist');

     $response->assertSeeText('');
    }
}