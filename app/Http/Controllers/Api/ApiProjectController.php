<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Project;

class ApiProjectController extends Controller
{
    public function data()
    {

        $data = Project::where("project_users",auth()->user()->users_id)
                ->get();


        return response()->json($data);
    }


    public function set(Request $request)
    {
        $result['success'] = 0;
        $result['message'] = "";
        $rules = array(
            'project_name'    => 'required', 
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {          
            $result['error'] = $validator->errors();
            $result['message'] = "Data is not complete.";
        }else{
            $data = [
                "project_name" => $request->project_name,
                "project_desc" => $request->project_desc,
                "project_users" => auth()->user()->users_id,
            ];
            if ($request->has("project_id")){
                Project::where("project_id",$request->project_id)->update($data);
                $result['success']=1;
            }else{
                if(Project::insert($data)){
                    $result['success']=1;
                }
            }
        }

        return response()->json($result);
    }

    public function destroy($id)
    {
        $result['success'] = 0;
        $result['message'] = "Data was not deleted.";

        if(Project::where("project_id",$id)->delete()){
            $result['success']=1;
        }

        return response()->json($result);

    }
}
