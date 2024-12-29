<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/');
        }

        $request->user()->markEmailAsVerified();
        event(new Verified($request->user()));

        return redirect()->route('profile.form');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
        return redirect('/');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
