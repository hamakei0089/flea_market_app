<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Artisan;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function payment_method_is_displayed_in_summary_when_selected()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();
        $response = $this->get(route('item.detail', $item->id));
        $response->assertStatus(200);

        $response = $this->get(route('purchase.form', $item->id));
        $response->assertStatus(200);

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                    ->visit(route('purchase.show', ['item' => $item->id]))
                    ->select('payment_method', 'カード支払い')
                    ->waitForText('カード支払い')
                    ->assertSee('カード支払い');
        });
    }
}
