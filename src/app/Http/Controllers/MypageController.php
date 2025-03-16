<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Evaluation;
use App\Models\Purchase;
use App\Models\Item;
use Illuminate\Support\Facades\DB;


class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $averageScore = Evaluation::where('evaluated_id', $user->id)->avg('score');
        $roundedScore = round($averageScore);

        $viewTypes = $request->get('page', 'sell');

        $sellItems = $user->items()->get();

        $buyItems = $user->purchases()->get();

        $purchaseItems = Purchase::where('user_id' , auth()->id())->get();
        $soldItemIds = Item::where('user_id', auth()->id())->pluck('id');
        $soldMyItems = Purchase::whereIn('item_id', $soldItemIds)->get();

        $messageItems = $purchaseItems->merge($soldMyItems);

        $messageItems = $messageItems->sortByDesc(function ($purchase) {
            $latestMessage = $purchase->messages()->latest()->first();
            return $latestMessage ? $latestMessage->created_at : $purchase->created_at;
        });

        $messageItems = $messageItems->map(function ($purchase) {
            $purchase -> unreadCount = Message::where('item_id', $purchase->item_id)
                ->where('receiver_id', auth()->id())
                ->where('is_read', 0)
                ->count();
            return $purchase;
    });
        $totalUnreadCount = $messageItems->sum('unreadCount');

    $search = '';

    return view('mypage', compact('user','averageScore','roundedScore', 'sellItems', 'buyItems', 'viewTypes', 'messageItems','totalUnreadCount' , 'search'));
}

}
