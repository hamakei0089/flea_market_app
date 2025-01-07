<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function store(Comment $request, $itemId)
    {
        $request->validate([
            'comment' => 'required|string|max255',
        ]);

        $item = Item::findOrFail($itemId);

        Comment::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return redirect()->route('items.detail');

    }
}
