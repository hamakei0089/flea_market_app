<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Http\Requests\DestinationRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
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

    public function updateAddress(DestinationRequest $request , Item $item)
    {
        $user = $request->user();

        $user -> update([

        'post_code'=> $request -> input('post_code'),
        'address'=> $request -> input('address'),
        'building'=> $request -> input('building'),
    ]);

    return redirect()->route('purchase.form', ['item' => $item->id])->with('success' , '住所を変更しました。');
    }

    public function checkout(PurchaseRequest $request , Item $item)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));


        dd($request->input('payment_method'));
        session([
        'purchased_item_id' => $item->id,
        'payment_method'    => $request->input('payment_method'),
        ]);

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
        $paymentMethod = session('payment_method');

        $purchase = Purchase::create([
        'user_id'=> Auth::id(),
        'item_id'=> $itemId,
        'payment_method'=> $paymentMethod,
    ]);

    return view('success', compact('purchase'));
    }

    public function cancel(Item $item)
    {
        $itemId = session('purchased_item_id');

        $item = Item::findOrFail($itemId);

        return view('cancel' , compact('item'));
    }
}
