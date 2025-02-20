<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Item;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Artisan;

class PaymentMethodTest extends DuskTestCase
{

    /** @test */
    public function selecting_a_payment_method_updates_the_summary_display()
    {

        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                    ->visit(route('purchase.form', ['item' => $item->id]))

                    ->assertSeeIn('#payment-method-display', '選択されていません')
                    ->select('payment_method', 'カード支払い')
                    ->pause(500)
                    ->assertSeeIn('#payment-method-display', 'カード支払い')

                    ->select('payment_method', 'コンビニ支払い')
                    ->pause(500)
                    ->assertSeeIn('#payment-method-display', 'コンビニ支払い');
        });
    }
}
