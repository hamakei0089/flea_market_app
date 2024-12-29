<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
{

    $items = Item::all();

    $userItems = auth()->check() ? Item::where('user_id', auth()->id())->get() : [];

    return view('index', compact('items', 'userItems'));
}

}
