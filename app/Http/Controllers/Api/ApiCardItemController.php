<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\CardItem;

class ApiCardItemController extends Controller
{
    public function data($project, $card)
    {

        $data = CardItem::where("sub_todo",$card)
                ->get();


        return response()->json($data);
    }


    public function set(Request $request, $project, $card)
    {
        $result['success'] = 0;
        $result['message'] = "";
        $rules = array(
            'sub_name'    => 'required', 
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {          
            $result['error'] = $validator->errors();
            $result['message'] = "Data is not complete.";
        }else{
            $data = [
                "sub_name" => $request->sub_name,
                "sub_todo" => $card,
            ];
            if ($request->has("id")){
                CardItem::where("sub_id",$request->id)->update($data);
                $result['success']=1;
            }else{
                if(CardItem::insert($data)){
                    $result['success']=1;
                }
            }
        }

        return response()->json($result);
    }

    public function destroy($project,$card,$id)
    {
        $result['success'] = 0;
        $result['message'] = "Data was not deleted.";

        if(CardItem::where("sub_id",$id)->delete()){
            $result['success']=1;
        }

        return response()->json($result);

    }


    public function checked(Request $request,$project,$card,$id)
    {
        $result['success'] = 0;
        $result['message'] = "Data was not updated.";

        if(CardItem::where("sub_id",$id)->update(["sub_status"=>$request->status])){
            $result['success']=1;
        }

        return response()->json($result);

    }

}
