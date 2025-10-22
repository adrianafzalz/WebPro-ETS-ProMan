<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use App\Models\PROJECT;
use App\Models\COLLABORATOR;

class UserController extends Controller
{
    public function seeUserProject(string $id) {

        $logged_id = Auth::id();
        if ($logged_id != null && (int) $logged_id == (int) $id ) {
            return redirect()->route('user.me');
        }


        $project_fetch_res = PROJECT::where("USER_ID_PM", $id)->get()->flatMap(fn ($i) => [$i]);
        $project_fetch_res_as_collab = COLLABORATOR::where("USER_ID","=",$id)->get()->flatMap(fn ($i) => [$i->project]);//->flatMap(fn ($collaborator) => $collaborator->project);

        // error_log($fetch_res);
        // error_log($fetch_res_as_collab);

        $all_project_res = $project_fetch_res->merge($project_fetch_res_as_collab)->unique('ID')->values();

        for ($i = 0; $i < sizeof($all_project_res); $i++) {
            $all_project_res[$i]->project_status;
            $all_project_res[$i]->project_tech_stacks;
            $all_project_res[$i]->collaborators;
        }

        $all_project_res = $all_project_res->map(function ($project) {
            // Convert each model to an array and remove the keys
            return Arr::except($project->toArray(), ['project_start', 'project_date','project_links','project_milestone','PROJECT_STATUS_ID','USER_ID_PM']);
        });

        // return $fetch_res;
        return view('user.profile')->with('projects',$all_project_res);
    }
    



    public function seeMyProject() {

        $logged_id = Auth::id();



        $project_fetch_res = PROJECT::where("USER_ID_PM", $logged_id)->get()->flatMap(fn ($i) => [$i]);
        $project_fetch_res_as_collab = COLLABORATOR::where("USER_ID","=",$logged_id)->get()->flatMap(fn ($i) => [$i->project]);//->flatMap(fn ($collaborator) => $collaborator->project);

        // error_log($fetch_res);
        // error_log($fetch_res_as_collab);

        $all_project_res = $project_fetch_res->merge($project_fetch_res_as_collab)->unique('ID')->values();

        for ($i = 0; $i < sizeof($all_project_res); $i++) {
            $all_project_res[$i]->project_status;
            $all_project_res[$i]->project_tech_stacks;
            $all_project_res[$i]->collaborators;
        }

        $all_project_res = $all_project_res->map(function ($project) {
            // Convert each model to an array and remove the keys
            return Arr::except($project->toArray(), ['project_start', 'project_date','project_links','project_milestone','PROJECT_STATUS_ID','USER_ID_PM']);
        });

        // return $fetch_res;
        return view('user.profile')->with('projects',$all_project_res);
    }
}
