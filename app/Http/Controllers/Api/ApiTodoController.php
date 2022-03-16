<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Todo;
use App\Models\CardItem;

class ApiTodoController extends Controller
{
    public function data($project)
    {

        $data = Todo::where("todo_project",$project)
                ->where("todo_parent",0)
                ->get();


        return response()->json($data);
    }


    public function set(Request $request, $project)
    {
        $result['success'] = 0;
        $result['message'] = "";
        $rules = array(
            'todo_name'    => 'required', 
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {          
            $result['error'] = $validator->errors();
            $result['message'] = "Data is not complete.";
        }else{
            $data = [
                "todo_name" => $request->todo_name,
                "todo_project" => $project,
            ];
            if ($request->has("id")){
                Todo::where("todo_id",$request->id)->update($data);
                $result['success']=1;
            }else{
                if(Todo::insert($data)){
                    $result['success']=1;
                }
            }
        }

        return response()->json($result);
    }

    public function destroy($project,$id)
    {
        $result['success'] = 0;
        $result['message'] = "Data was not deleted.";

       // if (CardItem::where("todo_parent",$id)->delete()){

            if(Todo::where("todo_parent",$id)->orWhere("todo_id",$id)->delete()){
                $result['success']=1;
            }

        //}

        return response()->json($result);

    }


     public function cardSet(Request $request, $project, $list)
    {
        $result['success'] = 0;
        $result['message'] = "";
        $rules = array(
            'todo_name'    => 'required', 
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {          
            $result['error'] = $validator->errors();
            $result['message'] = "Data is not complete.";
        }else{
            $data = [
                "todo_name" => $request->todo_name,
                "todo_desc" => $request->todo_desc,
                "todo_parent" => $list,
                "todo_project" => $project,
            ];
            if ($request->has("id")){
                Todo::where("todo_id",$request->id)->update($data);
                $result['success']=1;
                $result['data']=$request->id;
            }else{
                $id = Todo::insertGetId($data);
                if($id){
                    $result['success']=1;
                    $result['data']=$id;
                }
            }
        }

        return response()->json($result);
    }


    public function cardDestroy($project,$list,$id)
    {
        $result['success'] = 0;
        $result['message'] = "Data was not deleted.";

        if(Todo::where("todo_parent",$list)->where("todo_id",$id)->delete()){
            $result['success']=1;
        }

        return response()->json($result);

    }
}
