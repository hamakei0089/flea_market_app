<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MypageController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();

    $viewTypes = $request->get('page', 'sell');

    $sellItems = $user->items()->get();
    $buyItems = $user->purchases()->get();
    $messageItems = Message::where(function($query) use ($user) {
        $query->where('sender_id', $user->id)
              ->orWhere('receiver_id', $user->id);
    })->with('item')
      ->get();

    $messageItems = $messageItems->unique(function($item) {
        return $item->item->id;
    });

    $search = '';

    return view('mypage', compact('user', 'sellItems', 'buyItems', 'viewTypes','messageItems', 'search'));
}
}
