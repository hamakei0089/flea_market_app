<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

use App\Models\User;
use App\Models\Item;

class MypageTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase , WithFaker;
     /** @test */
    public function test_user_profile_displays_correct_information()
{

    Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    $user = User::factory()->create();
    $this->actingAs($user);

    $item = Item::factory()->create(['user_id' => $user->id]);

    $purchasedItem = Item::factory()->create();
    $user->purchases()->create([
    'item_id' => $purchasedItem->id,
    'payment_method_id' => rand(1, 2),
    'post_code' => $this->faker->postcode(),
    'address' => $this->faker->address(),
    'building' => $this->faker->optional()->secondaryAddress(),
    ]);

    $response = $this->get(route('mypage.index', $user->id));

    $response->assertStatus(200);

    $response->assertSee($user->profile_image);
    $response->assertSee($user->name);


    $response = $this->get('/mypage?page=sell');
    $response->assertStatus(200);
    $response->assertSee($item->name);

    $response = $this->get('/mypage?page=buy');
    $response->assertStatus(200);
    $response->assertSeeText($purchasedItem->name);
}

}
