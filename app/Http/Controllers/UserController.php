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


        $final_data = [];

        for ($i = 0; $i < sizeof($fetch_res); $i++) {
            // error_log()
            $fetch_res[$i]->p_r_o_j_e_c_t_s_t_a_t_u_s;
            $fetch_res[$i]->p_r_o_j_e_c_t_t_e_c_h_s_t_a_c_k_s;
            // $fetch_res[$i]->status = $fetch_res[$i]->p_r_o_j_e_c_t_s_t_a_t_u_s->status_name;
        }
        //     array_push($final_data, $fetch_res[i]->status)
        // }


        // $fetch_res = PROJECT::where("USER_ID_PM", $logged_id)->find(1)->p_r_o_j_e_c_t_s_t_a_t_u_s->toJson();
        // $fetch_res = PROJECT::where("USER_ID_PM", $logged_id)->p_r_o_j_e_c_t_s_t_a_t_u_s;
        // for (i = 0; i < )
        return $fetch_res;

    }
}
