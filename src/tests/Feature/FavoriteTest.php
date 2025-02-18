<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class FavoriteTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_can_favorite_an_item()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'ConditionsTableSeeder']);

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        $initialCount = $item->favorites()->count();
        $response = $this->post(route('favorite.store', $item->id));

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->assertEquals($initialCount + 1, $item->favorites()->count());

        $response->assertStatus(302);
    }

    /** @test */
    public function the_favorite_icon_changes_when_favorited()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);
        $response->assertSee('☆');

        $this->post(route('favorite.store', $item->id));

        $response = $this->get(route('item.detail', $item->id));
        $response->assertSee('★');
    }

    /** @test */
    public function the_favorite_icon_changes_again_and_again()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);
        $response->assertSee('☆');

        $this->post(route('favorite.store', $item->id));

        $response = $this->get(route('item.detail', $item->id));
        $response->assertSee('★');

        $this->delete(route('favorite.destroy', $item->id));

        $response = $this->get(route('item.detail', $item->id));
        $response->assertSee('☆');
    }
}

