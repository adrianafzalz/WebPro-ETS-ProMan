<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\USER;
use App\Models\PROJECT;
use App\Models\PROJECTTECH;
use App\Models\PROJECTSTATUS;
use App\Models\PROJECTTECHSTACK;
use App\Models\COLLABORATOR;


class ProjectController extends Controller
{
    public function createPage()
    {

        $allAvailableTech = PROJECTTECH::get();
        $allAvailableStatus = PROJECTSTATUS::get();

        return view('project.create')->with('allTech',$allAvailableTech)->with('allStatus',$allAvailableStatus);
    }


    public function createProject(Request $request)
    {
        // error_log((string)$request->input('technologies'));
        error_log($request->input('name'));
        // try {
        // {
            DB::beginTransaction();
            // DB::transaction(function() use ($request) {
            $new_project = PROJECT::create([
                'USER_ID_PM' => Auth::id(),
                'PROJECT_STATUS_ID' => $request->input('status'),
                'project_name'      => $request->input('name'),
                'project_desc'      => $request->input('description'),
                'project_start'     => $request->input('start_date'),
                'project_date'      => $request->input('end_date'),
                // 'project_links'     => json_decode($request->input('links'),true),
                'project_links'     => $request->input('links') ?? '[]',
                // 'project_milestone' => json_decode($request->input('milestone'),true),
            ]);
            error_log($new_project->ID);

            if ($request->input('technologies') != null) {
                foreach ($request->input('technologies') as $tech_id) {
                    if ($tech_id == "" || $tech_id == null) {
                        continue;
                    }
                    PROJECTTECHSTACK::create([
                        'TECH_ID' => $tech_id,
                        'PROJECTS_ID' => $new_project->ID,
                    ]);
                }
            }
            if ($request->input('collaborators') != null) {

                foreach ($request->input('collaborators') as $collaborator_uname) {
                    if ($collaborator_uname == "" || $collaborator_uname == null) {
                        continue;
                    }
                    $collaborator_uname = "orang1";
                    $userID = USER::where('user_name','LIKE',$collaborator_uname);
                    if ($userID->count() <= 0) {
                        DB::rollBack();
                        return back()->withErrors([
                            'err' => 'collaborator '.$collaborator_name.' is not exist in our database',
                        ])->withInput();
                    }
                    COLLABORATOR::create([
                        'USER_ID' => $userID->get()->first()->ID,
                        'PROJECTS_ID' => $new_project->ID,
                    ]);
    
    
                }
            }
            // });

            

            DB::commit();

            return "success";
        // } catch (\Exception $e) {
        // // }{
        //     // DB::rollBack();
        //     error_log("gagal");
        //     return $e;
        // }

        
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
