<?php

use Illuminate\Support\Facades\Route;
use App\Models\USER;


use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
// use Illuminate#

Route::get('/', function () {
    return view('welcome');
});


Route::get('/coba', function () {
    return USER::all();
});
Route::prefix('/user/')->group(function() {
    Route::get('me', [UserController::class, 'seeMyProject'])->middleware('authCheck');

    Route::get('id/{id}', function (string $id) {
        return "Halo Saya:  ".$id.' '.Auth::id();
    })->name('user.profile');

});

use App\Http\Controllers\AuthController;
Route::get('/register', [AuthController::class, 'showRegisForm'])->name('regis');
Route::post('/register', [AuthController::class, 'attemptRegis'])->name('regis.attempt');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
