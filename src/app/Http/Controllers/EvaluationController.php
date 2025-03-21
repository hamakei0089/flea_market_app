<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Evaluation;
use App\Models\Message;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function store(Request $request)
    {
        $userId = auth()->id();
        $item = Item::findOrFail($request->item_id);

        if ($userId === $item->user_id) {

        $partnerId = Purchase::where('item_id', $item->id)->value('user_id');

        } else {

        $partnerId = $item->user_id;
        }

        $alreadyEvaluated = Evaluation::where('item_id', $request->item_id)
        ->where('evaluator_id', $userId)
        ->where('evaluated_id', $partnerId)
        ->exists();

        if ($alreadyEvaluated) {
            return redirect()->back()->with('error', '既に評価済みです。');
        }
        Evaluation::create([
            'item_id'      => $request->item_id,
            'evaluator_id' => Auth::id(),
            'evaluated_id' => $partnerId,
            'score'        => $request->score,
        ]);

        return redirect('/')->with('success', '評価を送信しました！');
    }
}
