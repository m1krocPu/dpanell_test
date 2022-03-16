<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use Hash;
use App\Models\User;
use DateTime;

class AuthController extends Controller
{
    public function __construct()
    {

    }

    public function index(){
    	if (Auth::check()){
        	return redirect()->intended('/');
        }
    	return view('login'); 
    }


    public function doLogin(Request $request){
    	if (Auth::check()){
        	return redirect()->intended('/');
        }

		$rules = array(
		    'username'    => 'required|email', 
		    'password' => 'required'
		);
        $validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
		    return redirect('login')
		        ->withErrors($validator)
		        ->withInput($request->except('password')); 
		} else {
		    $userdata = array(
		        'users_email'     => $request->username,
		        'password'  => $request->password,
		    );

		    if (Auth::attempt($userdata)) {
		    	User::where('users_email', $request->username)->update(array('users_logged' => new DateTime));
		        return redirect()->intended('/');
		    } else {   			    	  	     
		        return redirect('login')->withErrors(['login'=>'Email or Password incorrect.'])->withInput($request->except('password')); 
		    }
		}
    }

    public function doLogout(){	
    	Auth::logout();
    	return redirect('login');
	}


	public function changePasswordIndex(){
    	$d = User::where("users_id",auth()->user()->users_id)->first();

    	if (empty($d)){
			return redirect('/');
    	}
		return view('modules.change_password', compact('d')); 
	}

	public function changePassword(Request $request){
    	$rules = array(
		    'old_password'    => 'required', 
		    'new_password'    => 'required',
		    'c_password'    => 'required',
		);
        $validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
		    return redirect()->back()
		        ->withErrors($validator); 
		}

		if ($request->new_password!=$request->c_password){
				return redirect()->back()
			       	->withErrors(['new_password'=>'New Password and Password Confirmation was not match.']); 
		}

		$check =User::where("users_id",Auth::user()->users_id)->first();
		if (empty($check)){
			return redirect()->back();
		}

		if (!Hash::check($request->old_password, $check->users_pwd)){
			return redirect()->back()
			       	->withErrors(['old_password'=>'Old Password Incorrect.']); 
		}

		$data["users_pwd"] = Hash::make($request->new_password);

		User::where("users_id", $check->users_id)->update($data);

		return redirect("/");
    }
}
