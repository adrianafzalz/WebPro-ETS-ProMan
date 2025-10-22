<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MileStoneController extends Controller
{
    public function updateMilestone()
    {
        $project_id = $request->input('project_id');
        $milestone = $request->input('milestone');


        try {
            $fetch_res = PROJECT::where('ID','=',(int) $project_id)->get();
            if ($fetch_res()->USER_ID_PM != Auth::id()) {
                return 500;
            }
            
            update([
                'project_milestone' => json_decode($request->input('milestone'),true),
            ]);

            return 200;
        } catch (\Exception $e) {
            return 500;
        }



    }   
}
