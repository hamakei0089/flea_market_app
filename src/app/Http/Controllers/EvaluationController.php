<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function store(Request $request)
    {
        $message = Message::where('item_id', $request->item_id)
            ->orderBy('created_at', 'asc')
            ->firstOrFail();

        $evaluatedId = (Auth::id() === $message->sender_id) 
            ? $message->receiver_id 
            : $message->sender_id;

        Evaluation::create([
            'item_id'      => $request->item_id,
            'evaluator_id' => Auth::id(),
            'evaluated_id' => $evaluatedId,
            'score'        => $request->score,
        ]);

        return redirect('/')->with('success', '評価を送信しました！');
    }
}
