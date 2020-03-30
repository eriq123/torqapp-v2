<?php

namespace App\Http\Controllers\Api;

use App\Course;
use App\Department;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Response;
use Validator;

class AuthController extends Controller
{
    //API LOGIN

	public function login(Request $request) {

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
            // 'username' => $request->header('username'),
            // 'password' => $request->header('password')
        ];
 
        if (auth()->attempt($credentials)) {
			$this->data['user'] = auth()->user();
            $this->data['role'] = Auth::user()->roles()->first();
            $this->data['access_token'] = auth()->user()->createToken('Login Token')->accessToken;
            $this->data['success'] = 1;

            return response()->json(['data' => $this->data], 200);
        } else {
            $this->data['success'] = 0;

            return response()->json(['data' => $this->data], 422);
        }
	}

	// public function Sign(Request $request) {
	// 	if(!is_null($request->signature)){
	// 		$msg['user'] = User::where('id',$request->id)->update(['signature'=>$request->signature]);
	// 		$msg['user'] = User::where('id',$request->id)->get();
	// 		if($msg['user']){
	// 			$msg['success'] = "1";
	// 			$msg['message'] = "success";
	// 			return Response::json($msg,200);

	// 		}else{
	// 			$msg['success'] = "0";
	// 			$msg['message'] = "File NOT uploaded Successfully!";
	// 			return Response::json($msg,422);
	// 		}

	// 	}else {
	// 		$msg['success'] = "0";
	// 		$msg['message'] = "Required Parameter is not available";
	// 		return Response::json($msg,422);
	// 	}
	// }
}


