<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use Response;
use Hash;
use Validator;
use token;
use App\Course;
use App\Department;
use DB;

class AuthController extends Controller
{
    //API LOGIN

    public function login(Request $request) {
    	$user = User::select('id','username','first_name','last_name','password','course_id','role_id')->where('username', $request->username)->first();

	    if ($user) {
	        if (Hash::check($request->password, $user->password)) {
	           	 $msg['success'] = "1";
	           	 $msg['message'] = "success";
	           	 $msg['login'] = [$user];
	            return Response::json($msg,200);
	        } else {
	            $msg['success'] = "0";
	            $msg['message'] = "Email and Password did not match";
	            return Response::json($msg,422);
	        }
	    } else {
	        $msg['success'] = "0";
            $msg['message'] = "error";
	        return Response::json($msg,422);
	    }
	}

	public function Sign(Request $request) {
	if(!is_null($request->signature)){
		$msg['user'] = User::where('id',$request->id)->update(['signature'=>$request->signature]);
		$msg['user'] = User::where('id',$request->id)->get();
		if($msg['user']){
			$msg['success'] = "1";
			$msg['message'] = "success";
			return Response::json($msg,200);

		}else{
			$msg['success'] = "0";
			$msg['message'] = "File NOT uploaded Successfully!";
			return Response::json($msg,422);
		}
		
	}else {
		$msg['success'] = "0";
		$msg['message'] = "Required Parameter is not available";
		return Response::json($msg,422);
	}
	}
	// public function login(Request $request) {
 //    	$user = User::select('username','first_name','password')->where('username', $request->email)->first();

	//     if ($user) {
	//         if (Hash::check($request->password, $user->password)) {
	//            	 $msg['success'] = "1";
	//            	 $msg['message'] = "success";
	//            	 $msg['login'] = [$user];
	//             return Response::json($msg,200);
	//         } else {
	//             $msg['success'] = "0";
	//             $msg['message'] = "Email and Password did not match";
	//             return Response::json($msg,422);
	//         }
	//     } else {
	//         $msg['success'] = "0";
 //            $msg['message'] = "error";
	//         return Response::json($msg,422);
	//     }
	// }
}


