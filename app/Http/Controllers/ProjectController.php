<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\PROJECT;


class ProjectController extends Controller
{
    public function createPage()
    {
        return view('project.create');
    }

    
    public function createProject(Request $request)
    {
        try {
            PROJECT::create([
                'USER_ID_PM' => Auth()::id(),
                'PROJECT_STATUS_ID' => $request->input('status_id'),
                'project_name'      => $request->input('project_name'),
                'project_desc'      => $request->input('project_desc'),
                'project_start'     => $request->input('project_start'),
                'project_date'      => $request->input('project_end'),
                'project_links'     => json_decode($request->input('links'),true),
                // 'project_milestone' => json_decode($request->input('milestone'),true),
            ]);
        } catch (\Exception $e) {
            return 500;
        }

        
    }

    public function seeProject(Request $request, string $project_id)
    {
        $logged_id = Auth::id();
        
        $project_fetch = PROJECT::where('ID','=',(int) $project_id)->get()->first();
        // $project_fetch->setRelation('project_links', json_decode($project_fetch->project_links));
        $project_fetch->project_status;
        $project_fetch->project_tech_stacks;
        $project_fetch->collaborators;

        return view('project.projectdetails')->with('project',$project_fetch);

    }

    public function editProject(string $id)
    {
        try {
            $fetch_res = PROJECT::where('ID','=',(int) $project_id)->get();
            if ($fetch_res()->USER_ID_PM != Auth::id()) {
                return 500;
            }
            
            update([
                // 'USER_ID_PM' => Auth()::id(), // not used for update
                'PROJECT_STATUS_ID' => $request->input('status_id'),
                'project_name'      => $request->input('project_name'),
                'project_desc'      => $request->input('project_desc'),
                'project_start'     => $request->input('project_start'),
                'project_date'      => $request->input('project_end'),
                'project_links'     => json_decode($request->input('links'),true),
                // 'project_milestone' => json_decode($request->input('milestone'),true),
            ]);

            return 200;
        } catch (\Exception $e) {
            return 500;
        }
    }
    
    public function removeProject(string $id)
    {
        try {
            $fetch_res = PROJECT::where('ID','=',(int) $project_id)->get();

            if ($fetch_res()->USER_ID_PM != Auth::id()) {
                return 500;
            }
            
            $fetch_res->delete();


            return 200;
        } catch (\Exception $e) {
            return 500;
        }
    }


}
