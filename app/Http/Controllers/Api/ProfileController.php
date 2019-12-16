<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use Response;

class ProfileController extends Controller
{
    //READ
    public function readprofile(Request $request) {
    	$profile = User::select('id','username','first_name','last_name')->where('id', $request->id)->get();

    	$msg['success'] = "1";
	   	$msg['message'] = "success";
	   	$msg['read'] = $profile;
	    return Response::json($msg,200);
    }

     public function editprofile(Request $request) {
      	$request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
        ]);
        $profile = User::where('id',$request->id)->update(['first_name'=>$request->first_name,'last_name'=>$request->last_name,'username'=>$request->email]);
        if($profile){
        	$msg['success'] = "1";
		   	$msg['message'] = "success";
		    return Response::json($msg,200);
        }else{
        	$msg['success'] = "0";
		   	$msg['message'] = "error";
		    return Response::json($msg,422);
        }
        
    }

}

