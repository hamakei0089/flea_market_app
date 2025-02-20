<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\PaymentMethod;
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
        $paymentMethods =PaymentMethod::all();

        return view('purchase' , compact('item' , 'user' , 'search' , 'paymentMethods'));
    }

    public function editAddress(Item $item)
    {
        $user = auth()->user();
        $search = '';

        return view('edit_address' , compact('user' , 'item', 'search'));
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

    public function checkout(PurchaseRequest $request, Item $item)
{
    $user = auth()->user();

    Stripe::setApiKey(config('services.stripe.secret'));

    $paymentMethod = PaymentMethod::where('name', $request->input('payment_method'))->first();

    session(['purchased_item_id' => $item->id]);
    session(['payment_method_id' => $paymentMethod->id]);

    $checkoutSession = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ],
        ],
        'mode' => 'payment',
        'success_url' => route('purchase.success', ['item' => $item->id]) . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('purchase.cancel', ['item' => $item->id]),
    ]);
    return redirect()->to($checkoutSession->url);
}


    public function success(Request $request , Item $item)
    {
        $user = auth()->user();

        $itemId = session('purchased_item_id');
        $paymentMethodId = session('payment_method_id');

        $purchase = Purchase::create([
        'user_id'=> Auth::id(),
        'item_id'=> $itemId,
        'payment_method_id' => $paymentMethodId,
        'post_code' => $user->post_code,
        'address' =>  $user->address,
        'building' => $user->building,
    ]);

    return view('success', compact('purchase'));
    }

    public function cancel(Item $item)
    {

        $user = auth()->user();

        $itemId = session('purchased_item_id');

        $item = Item::findOrFail($itemId);

        return view('cancel' , compact('item'));
    }
}
