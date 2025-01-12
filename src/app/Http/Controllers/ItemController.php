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
                ->with(['categories','condition','comments.user'])
                ->findOrFail($id);

        return view('detail' , compact('item'));
    }

}
