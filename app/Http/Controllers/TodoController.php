<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Project;

class TodoController extends Controller
{
    public function index()
    {

        return view('modules.todo.index');
    }


    public function list($id)
    {
    	$d = Project::where("project_id",$id)->first();

    	if (empty($d)){
    		return redirect("todo");
    	}
        return view('modules.todo.list', compact('d'));
    }
}
