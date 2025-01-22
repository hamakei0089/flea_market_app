<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $item=Item::all();

        $user=User::select('post_code' , 'address' , 'building')->get();

    return view('purchase' , compact('item' , 'user'));
    }

    public function editAddress()
    {
        $user = auth()->user(['post_code' , 'address' , 'building']);

        return view('edit-address' , compact('user'));
    }

    public function updateAddress(Request $request)
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

    return view('purchase')->with('success' , '住所を変更しました。');
    }
}
