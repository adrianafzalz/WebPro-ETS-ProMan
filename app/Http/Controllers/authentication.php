<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authentication extends Controller
{
    //

    public function login(Request $request)
    {
        $request->validate([
            'user_name' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('user_name','password');

        $guards = ['user'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt($credentials)) {
                $request->session()->regenerate();

                return match($guard) {
                    'admin' => redirect()->route('user.profile', ['id' => Auth::user()->id]),
                };
            }
        }
    }
}
