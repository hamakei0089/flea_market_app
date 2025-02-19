<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\PaymentMethod;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
    public function purchase_is_saved_after_success()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        $user = User::factory()->create();
        $item = Item::factory()->create();
        $paymentMethod = PaymentMethod::first();

        $this->actingAs($user);

        $this->post(route('purchase.checkout', ['item' => $item->id]), [
            'payment_method' => $paymentMethod->name,
        ]);

        $response = $this->get(route('purchase.success', ['item' => $item->id]));

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method_id' => $paymentMethod->id,
            'post_code' => $user->post_code,
            'address' =>  $user->address,
            'building' => $user->building,
        ]);
    }

    /** @test */
    public function Sold_label_is_displayed_for_an_item_after_being_purchased()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'CategoriesTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'ConditionsTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'PaymentMethodsTableSeeder']);

        $user = User::factory()->create();
        $item = Item::factory()->create();
        $paymentMethod = PaymentMethod::first();

        $this->actingAs($user);

        $this->post(route('purchase.checkout', ['item' => $item->id]), [
            'payment_method' => $paymentMethod->name,
        ]);

        $response = $this->get(route('purchase.success', ['item' => $item->id]));

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method_id' => $paymentMethod->id,
            'post_code' => $user->post_code,
            'address' =>  $user->address,
            'building' => $user->building,
        ]);

        $response = $this->get('/');

        $response->assertSee('Sold');
        $response->assertSee($item->name);

    }

     /** @test */
    public function purchased_item_is_saved_on_mypage()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'CategoriesTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'ConditionsTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'PaymentMethodsTableSeeder']);

        $user = User::factory()->create();
        $item = Item::factory()->create();
        $paymentMethod = PaymentMethod::first();

        $this->actingAs($user);

        $this->post(route('purchase.checkout', ['item' => $item->id]), [
            'payment_method' => $paymentMethod->name,
        ]);

        $response = $this->get(route('purchase.success', ['item' => $item->id]));

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method_id' => $paymentMethod->id,
            'post_code' => $user->post_code,
            'address' =>  $user->address,
            'building' => $user->building,
        ]);

        $response = $this->get('/mypage?page=buy');

        $response->assertSee($item->name);

    }
}
