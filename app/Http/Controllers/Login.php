<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    //
    public function store(Request $request)
    {
        /**
         * validate request
         */
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        //get email and password from request
        $credentials = $request->only('email', 'password');

        //attempt to login
        if (Auth::attempt($credentials)) {

            //regenerate session
            $request->session()->regenerate();

            //redirect route dashboard
            return redirect('/dashboard');
        }

        //if login fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/');
    }
}
