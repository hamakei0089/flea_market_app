<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Condition;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ListingRequest;

class ListingController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        $search = '';

        return view ('listing' , compact('categories' , 'conditions' , 'search'));
    }

    public function store(ListingRequest $request)
{
    $image_path = $request->file('thumbnail')->store('images' , 'public');
    $condition = Condition::where('name', $request->input('condition'))->first();

    $item = Item::create([
        'thumbnail' => $image_path,
        'condition_id' => $condition->id,
        'user_id' => Auth::id(),
        'name' => $request->input('name'),
        'brand_name' => $request->input('brand_name'),
        'description' => $request->input('description'),
        'price' => $request->input('price'),
    ]);

    $item->categories()->sync($request->input('categories'));

    return redirect('/')->with('success', '出品登録が完了しました');
}
}
