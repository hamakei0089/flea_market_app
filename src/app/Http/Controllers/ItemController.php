<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $Items = Item::all();
        $viewTypes = $request ->get('page' , 'all' );

        $user = Auth::user();
        $myLists = [];

        if($user){

        $myLists = $user ->favorites()->with('item')->get();

        }

        return view('index' , compact('Items' , 'viewTypes' , 'user', 'myLists'));
    }

    public function show($id)
    {
        $item = Item::withCount(['favorites', 'comments'])
                    ->with(['categories', 'condition', 'comments.user'])
                    ->findOrFail($id);

        $isFavorited = $item->favoritedBy->contains('user_id', auth()->id());

        return view('detail', compact('item', 'isFavorited'));
    }

    public function like(Item $item)
    {
        $user = auth()->user();

        if ($user->favorites()->where('item_id', $item->id)->exists()) {
            $user->favorites()->where('item_id', $item->id)->delete();
            $isFavorited = false;
        } else {
            $user->favorites()->create(['item_id' => $item->id]);
            $isFavorited = true;
        }

        $favoritesCount = $item->favorites()->count();

        return response()->json([
            'isFavorited' => $isFavorited,
            'favorites_count' => $favoritesCount,
        ]);
    }

}
