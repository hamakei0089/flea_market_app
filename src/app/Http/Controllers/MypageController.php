<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index(Request $request)
    {

    $user = auth()->user();
    $viewTypes = $request ->get('sell' , 'buy' );

    $sellItems = $user->items();
    $buyItems = $user->purchases();

    return view('mypage' , compact('user' , 'sellItems' , 'buyItems' ,'viewTypes'));
    }
}
