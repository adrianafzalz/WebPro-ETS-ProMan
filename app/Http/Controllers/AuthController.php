<?php

namespace App\Http\Controllers;

use App\Models\User;

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

        $getUser = User::where('user_name', $request->input('user_name'))->first();

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

    public function register(Request $request) {
        $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);
        

        // check user_name is available
        $is_user_name_taken = (User::where('user_name','LIKE',$request->input('user_name'))->count()) > 0;

        if ($is_user_name_taken) {
            return back()->withErrors([
                'user_name' => 'user_name has already taken by someone else',
            ])->onlyInput('user_name');
            return;
        }

        User::create(['user_name'=>$request->input('user_name'),'password'=>Hash::make($request->input('password'))]);

        // Log the user in 
        $user =  User::where('user_name', $request->input('user_name'))->first();
        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
        }

        return redirect()->route('user.profile', ['id' => Auth::id()]);

        return;


        // $credentials = [
        //     'user_name' => $request->input('user_name'),
        //     'password' => $request->input('password'),
        // ];
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
