<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

    public function store(Request $request, $item_id)
    {

        $validated = $request->validate([
        'comment' => 'required|max:255',
    ], [
        'comment.required' => 'コメントの入力は必須です。',
        'comment.max' => 'コメントは255文字以内で入力してください。',
    ]);


        $item = Item::findOrFail($item_id);

        Comment::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('item.detail' , ['item' => $item->id])
                        ->with('success' , 'コメントを追加しました。');

    }
}
