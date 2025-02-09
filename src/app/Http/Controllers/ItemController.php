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
        $items = Item::all();
        $viewTypes = $request ->get('page' , 'all' );

        $user = auth()->user();
        $myLists = [];

        if($user){

        $myLists = Favorite::where('user_id', auth()->id())->with('item')->get();


        }

        return view('index' , compact('items' , 'viewTypes' , 'user', 'myLists'));
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
        return view('detail', compact('item', 'isFavorited'));
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