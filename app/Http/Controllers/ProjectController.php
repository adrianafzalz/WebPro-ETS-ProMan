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
        // Validate input
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'status' => ['required'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date','after_or_equal:start_date'],
            'description' => ['required','string'],
            'links' => ['nullable','array'],
            'links.*' => ['nullable','string','max:2000'],
            'technologies' => ['nullable','array'],
            'technologies.*' => ['nullable','integer'],
            'collaborators' => ['nullable','array'],
            'collaborators.*' => ['nullable','string','max:255'],
        ]);

        // Sanitize arrays: remove empty/null values and reindex
        $links = array_values(array_filter((array) $request->input('links', []), function ($v) {
            return !is_null($v) && trim((string) $v) !== '';
        }));

        $technologies = array_values(array_filter((array) $request->input('technologies', []), function ($v) {
            return !is_null($v) && trim((string) $v) !== '';
        }));

        $collaborators = array_values(array_filter((array) $request->input('collaborators', []), function ($v) {
            return !is_null($v) && trim((string) $v) !== '';
        }));

        try {
            $new_project = DB::transaction(function () use ($validated, $links, $technologies, $collaborators) {
                $project = PROJECT::create([
                    'USER_ID_PM' => Auth::id(),
                    'PROJECT_STATUS_ID' => $validated['status'],
                    'project_name' => $validated['name'],
                    'project_desc' => $validated['description'],
                    'project_start' => $validated['start_date'],
                    'project_date' => $validated['end_date'],
                    'project_links' => empty($links) ? null : json_encode($links),
                ]);

                // Attach technologies
                foreach ($technologies as $tech_id) {
                    if (!is_numeric($tech_id)) continue;
                    PROJECTTECHSTACK::create([
                        'TECH_ID' => (int) $tech_id,
                        'PROJECTS_ID' => $project->ID,
                    ]);
                }

                // Attach collaborators
                foreach ($collaborators as $collaborator_uname) {
                    $user = USER::where('user_name', 'LIKE', $collaborator_uname)->first();
                    if (!$user) {
                        throw new \Exception('Collaborator "' . $collaborator_uname . '" does not exist');
                    }
                    COLLABORATOR::create([
                        'USER_ID' => $user->ID,
                        'PROJECTS_ID' => $project->ID,
                    ]);
                }

                return $project;
            });

            // success — redirect to project details or return success
            return redirect()->route('project.show', [$new_project->ID])->with('success', 'Project created');
        } catch (\Exception $e) {
            error_log('Project create failed: ' . $e->getMessage());
            return back()->withErrors(['err' => $e->getMessage()])->withInput();
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
