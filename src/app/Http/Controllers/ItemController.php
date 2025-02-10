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

        $itemsQuery = Item::query();
        if (!empty($search)) {
            $itemsQuery->where('name', 'like', "%{$search}%");
        }

        $user = auth()->user();
        if($user){
            $itemsQuery->where(function ($query) use ($user) {
        $query->where('user_id', '!=', $user->id)
              ->orWhereNull('user_id');
        });
        }

        $items = $itemsQuery->get();

        $user = auth()->user();
        $myLists = [];

        if ($user) {
            $myListsQuery = Favorite::where('user_id', auth()->id())->with('item');
            if (!empty($search)) {

                $myListsQuery->whereHas('item', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            }
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