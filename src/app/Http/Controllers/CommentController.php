<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;


class CommentController extends Controller
{

    public function store(CommentRequest $request, $item_id)
    {

        $item = Item::findOrFail($item_id);

        Comment::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('item.detail' , ['item' => $item->id])
                        ->with('success' , 'コメントを追加しました。');

    }
}
