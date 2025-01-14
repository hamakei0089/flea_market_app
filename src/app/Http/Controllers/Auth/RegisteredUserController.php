<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;

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

        Auth::login($user);

        return redirect()->route('profile.form');
    }


    public function showProfileForm(Request $request)
    {
        $user = auth()->user();

        return view('auth.profile' , ['user' => $user]);
    }


    public function updateProfile(Request $request)
    {
        $request->validate([

        'name' => 'required|string|max:255',
        'post_code' => 'required',
        'address' => 'required',
        'building' => 'nullable|string|max:255',
        'thumbnail' => 'nullable',
    ]);

        $user = $request->user();

        if ($request->hasFile('thumbnail')) {

        $image_path = $request->file('thumbnail')->store('public/profiles');

        $thumbnail_name = basename($image_path);
    } else {
        $thumbnail_name = null;
    }
        $user -> update([

        'name'=> $request -> input('name'),
        'post_code'=> $request -> input('post_code'),
        'address'=> $request -> input('address'),
        'building'=> $request -> input('building'),
        'thumbnail' => $thumbnail_name,
        'is_profile_complete' => true,
    ]);

    return redirect('/');
    }
}