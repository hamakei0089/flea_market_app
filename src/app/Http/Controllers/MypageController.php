<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\DB;


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

        $unreadCount = Message::where('receiver_id', auth()->id())
        ->where('is_read', false)
        ->count();

        $itemUnreadCounts = Message::select('item_id', DB::raw('count(*) as unread_count'))
        ->where('receiver_id', auth()->id())
        ->where('is_read', false)
        ->groupBy('item_id')
        ->pluck('unread_count', 'item_id');

        $messageItems = $messageItems->unique(function($item) {
            return $item->item->id;
        });

        foreach ($messageItems as $messageItem) {
            $itemId = $messageItem->item->id;
            $messageItem->unread_count = $itemUnreadCounts->get($itemId, 0);
        }

        $search = '';

        return view('mypage', compact('user', 'sellItems', 'buyItems', 'viewTypes','messageItems','unreadCount', 'search'));
    }
}
