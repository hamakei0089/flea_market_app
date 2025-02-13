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

    public function checkout(Item $item)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        session(['purchased_item_id' => $item->id]);

        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success' , ['item' => $item->id]),
            'cancel_url' => route('purchase.cancel' , ['item' => $item->id]),
        ]);

        return redirect($checkout_session->url);
    }

    public function success(Item $item)
    {

        $itemId = session('purchased_item_id');

        $item = Item::findOrFail($itemId);

        $item -> update([
        'is_purchased'=> 1,
    ]);

    return view('success', compact('item'));
    }

    public function cancel(Item $item)
    {
        $itemId = session('purchased_item_id');

        $item = Item::findOrFail($itemId);

        return view('cancel' , compact('item'));
    }
}
