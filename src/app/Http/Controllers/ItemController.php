<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
{

    $items = Item::all();

    // ログインしている場合、出品した商品も取得
    $userItems = auth()->check() ? Item::where('user_id', auth()->id())->get() : [];

    return view('items.index', compact('items', 'userItems'));
}

}
