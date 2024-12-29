<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;

class RegisteredUserController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actions\Fortify\CreateNewUser  $creator
     * @return \Laravel\Fortify\Contracts\RegisterResponse
     */

    public function index()
    {
        return view('auth.register');
    }


    public function store(RegisterUserRequest $request, CreateNewUser $creator)
    {
        $user = $creator->create($request->validated());

        $user->sendEmailVerificationNotification();

        /*event(new Registered($user));*/

        return redirect('/login');
    }

    public function showProfileForm(Request $request)
    {
        return view('auth.profile');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([

        'name' => 'required|string|max:255',
        'post_code' => 'required',
        'address' => 'required',
    ]);

        $user = $request->user();

        $user -> update([

        'name'=> $request -> input('name'),
        'post_code'=> $request -> input('post_code'),
        'address'=> $request -> input('address'),
        'building'=> $request -> input('building'),
        'is_profile_complete' => true,
    ]);
    }
}