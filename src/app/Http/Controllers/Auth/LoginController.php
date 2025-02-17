<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
{
    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
    ], $request->filled('remember'))) {

        $user = Auth::user();

        if ($user->email_verified_at === null) {
            $user->sendEmailVerificationNotification();
            return redirect()->route('verification.notice');
        }

        if (!$user->is_profile_complete) {
            return redirect()->route('profile.form');
        }

        return redirect('/');
    }

    return $request->failedLoginResponse();
    }
}
