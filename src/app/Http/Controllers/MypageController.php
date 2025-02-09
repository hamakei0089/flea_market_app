<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();

    $viewTypes = $request->get('page', 'sell');

    $sellItems = $user->items()->get();
    $buyItems = $user->purchases()->get();

    $search = '';

    return view('mypage', compact('user', 'sellItems', 'buyItems', 'viewTypes', 'search'));
}
}
