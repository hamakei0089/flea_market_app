<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
{
    $allItems = Item::all();

    $user = Auth::user();
    $myLists = $user ->favorites()->get();

    return view('index' , compact('allItems' , 'user', 'myLists'));
}

}
