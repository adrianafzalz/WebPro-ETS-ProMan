<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\PROJECT;

class UserController extends Controller
{
    public function seeUserProject(string $id) {

        return PROJECT::where('USER_ID_PM', $id);
    }
    
    public function seeMyProject() {
        $logged_id = Auth::id();

        $fetch_res = PROJECT::where("USER_ID_PM", $logged_id)->get();
        return $fetch_res;

    }
}
