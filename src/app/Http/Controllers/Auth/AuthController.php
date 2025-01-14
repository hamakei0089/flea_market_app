<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }


    public function authenticated(Request $request, $user)
    {
        if(!$user->is_profile_complete){
            return redirect()->route('profile.form');
        }

        return redirect('/');

    }
}
