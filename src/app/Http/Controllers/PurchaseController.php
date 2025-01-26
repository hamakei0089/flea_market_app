<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;

class PurchaseController extends Controller
{
    public function index(Item $item)
    {

        $user = auth()->user();

        return view('purchase' , compact('item' , 'user'));
    }

    public function editAddress(Item $item)
    {
        $user = auth()->user();

        return view('edit-address' , compact('user' , 'item'));
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
}
