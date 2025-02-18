<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Artisan;

class DestinationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
     /** @test */
    public function user_can_update_address_and_see_changes()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        $this->get(route('purchase.form', $item->id));
        $response->assertStatus(200);

        $this->get(route('edit.address', $item->id));
        $response->assertStatus(200);


        $response = $this->post(route('update.address', $item->id), [
        'post_code' => '123-4567',
        'address' => '大阪府大阪市1-1',
        'building' => '大阪ビル123',
        ]);
        $response->assertStatus(302);

        $response->assertRedirect(route('purchase.form', ['item' => $item->id]));

        $response = $this->get(route('purchase.form', ['item' => $item->id]));

        $response->assertSeeInOrder(['123-4567', '大阪府大阪市1-1', '大阪ビル123']);

    }
}
