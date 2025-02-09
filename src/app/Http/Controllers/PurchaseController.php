<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function index(Item $item)
    {

        $user = auth()->user();
        $search = '';

        return view('purchase' , compact('item' , 'user' , 'search'));
    }

    public function editAddress(Item $item)
    {
        $user = auth()->user();
        $search = '';

        return view('edit-address' , compact('user' , 'item', 'search'));
    }

    public function updateAddress(Request $request , Item $item)
    {
        $request->validate([

        'post_code' => 'required',
        'address' => 'required',
        'building' => 'nullable|string|max:255',
    ]);

        $user = $request->user();

        $user -> update([

        'post_code'=> $request -> input('post_code'),
        'address'=> $request -> input('address'),
        'building'=> $request -> input('building'),
    ]);

    return redirect()->route('purchase.form', ['item' => $item->id])->with('success' , '住所を変更しました。');
    }

    public function payment(Request $request, Item $item)
    {

        $user = auth()->user();

        $paymentMethod = $request->input('payment_method');

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [[
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => $item->name,
                ],
                'unit_amount' => $item->price * 100,
            ],
            'quantity' => 1,
        ]];

        // Stripeの決済セッションを作成
        try {
            $session = Session::create([
                'payment_method_types' => $paymentMethod === 'カード支払い' ? ['card'] : ['convenience'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
            ]);

            return redirect()->away($session->url);
        } catch (\Exception $e) {

            return back()->withErrors('支払い処理に失敗しました。');
        }
    }
}

