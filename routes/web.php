<?php

use Illuminate\Support\Facades\Route;
use App\Models\USER;


use Illuminate\Support\Facades\Auth;
// use Illuminate#

Route::get('/', function () {
    return view('welcome');
});


Route::get('/coba', function () {
    return USER::all();
});

/* ------------------------------- User route ------------------------------- */
use App\Http\Controllers\UserController;
Route::prefix('/user/')->group(function() {

    Route::get('/me', [UserController::class, 'seeMyProject'])->name('user.me')->middleware('authCheck');
    Route::get('/{id}', [UserController::class, 'seeUserProject'])->name('user.profile');

    // Route::get('id/{id}', function (string $id) {
    //     return "Halo Saya:  ".$id.' '.Auth::id();
    // })->name('user.profile');

});

/* ------------------------------- Auth route ------------------------------- */
use App\Http\Controllers\AuthController;
Route::prefix('/auth/')->group(function() {

    Route::get('/register', [AuthController::class, 'showRegisForm'])->name('regis');
    Route::post('/register', [AuthController::class, 'attemptRegis'])->name('regis.attempt');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

/* ------------------------------ Project Route ----------------------------- */
use App\Http\Controllers\ProjectController;
Route::prefix('/project')->group(function() {

    Route::get('/create', [ProjectController::class, 'createPage'])->name('project.create.page')->middleware('authCheck');
    Route::post('/create', [ProjectController::class, 'createProject'])->name('project.create.attempt')->middleware('authCheck');
    
    Route::get('/detail/{id}', [ProjectController::class, 'seeProject'])->name('project.see');

    Route::post('/edit', [ProjectController::class, 'createProject'])->name('project.create')->middleware('authCheck');
    // Route::post('/create', [ProjectController::class, 'createProject'])->name('project.create');
    // Route::post('/create', [ProjectController::class, 'createProject'])->name('project.create');
});
