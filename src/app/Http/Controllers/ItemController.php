<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
{
    $search = $request->query('search', '');
    $viewTypes = $request->query('page', 'all');

    $itemsQuery = Item::with('purchase');
    if (!empty($search)) {
        $itemsQuery->where('name', 'like', "%{$search}%");
    }

    $user = auth()->user();

    if ($user) {
        $itemsQuery->where(function ($query) use ($user) {
            $query->where('user_id', '!=', $user->id)
                  ->orWhereNull('user_id');
        });
    }

    $items = $itemsQuery->get();

    $myLists = [];

    if ($user) {
        $myListsQuery = Favorite::where('user_id', $user->id)
            ->whereHas('item', function ($query) use ($search) {
                if (!empty($search)) {
                    $query->where('name', 'like', "%{$search}%");
                }
            })
            ->with(['item' => function ($query) use ($user) {
                $query->where('user_id', '!=', $user->id)
                      ->orWhereNull('user_id')
                      ->with('purchase');
            }]);

        $myLists = $myListsQuery->get();
    }

    return view('index', compact('items', 'viewTypes', 'user', 'myLists', 'search'));
}




    public function show($id)
    {
        $item = Item::withCount(['favorites', 'comments'])
                    ->with(['categories', 'condition', 'comments.user'])
                    ->findOrFail($id);

        $isFavorited = false;
        if(auth()->check()){

        $isFavorited = $item->favoritedBy->contains('user_id', auth()->id());
        }

        $search = '';

        return view('detail', compact('item', 'isFavorited' , 'search'));
    }

    public function like(Item $item){

    $user = Auth::user();

    if(!$item->isfavoritedBy($user)){
        $item->favoritedBy()->attach($user->id);
    }
    return back();
    }

    public function destroy(Item $item){

    $user = Auth::user();

    if($item->isfavoritedBy($user)){
        $item->favoritedBy()->detach($user->id);
    }
    return back();
    }
}