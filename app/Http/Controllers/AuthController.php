<?php

namespace App\Http\Controllers;

use App\Models\USER;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showRegisForm()
    {
        return view('auth.regis');
    }

    public function attemptRegis()
    {

    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // error_log("post logn");
        $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'user_name' => $request->input('user_name'),
            'password' => $request->input('password'),
        ];

        $getUser = USER::where('user_name', $request->input('user_name'))->first();

        error_log($getUser);
        error_log( strlen(Hash::make($request->input('password'))) );
        error_log(strlen($getUser->password));
        // if ($getUser && Hash::check($request->input('password'), $getUser->password)) {
            // Auth::login($getUser);

        if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('user.profile', ['id' => Auth::id()]);
        }

        return back()->withErrors([
            'user_name' => 'The provided credentials do not match our records.',
        ])->onlyInput('user_name');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
