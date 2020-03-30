<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\PPMP;
// use App\User;
// use App\Item;
// use App\Course;
// use App\Department;
// use App\Budget;
// use App\app;
// use App\Requests;
// use Response;


class RequestController extends Controller
{
    //View ALL PPMP
	public function ppmp_all(Request $request){
		$ppmp = PPMP::all();

        return response()->json($ppmp, 200);
	}

	public function ppmp(Request $request){

		$ppmp = PPMP::where('user_id',$request->user()->id)->get();

		return response()->json($ppmp, 200);
	}

//     // View PPMP
// 	public function ppmpview(Request $request){
// 		$ppmp = PPMP::with('items')->where('course_id',$request->getId)->get();

// 		return response()->json(compact('ppmp'));
// 	}

// 	// View APP
// 	public function appview(Request $request){
// 		$app = APP::with('items')->where('course_id',$request->getId)->get();

// 		return response()->json(compact('app'));
// 	}
// 	 //View ALL APP
// 	public function appviews(Request $request){
// 		$app = app::all();

// 		return Response::json($app);
// 	}

//     //View Courses
//     public function dept(Request $request) {
//     	$Departments = Department::with('courses')->get();

//    		return Response::json($Departments);
// 	}

// 	 //View Courses
//     public function budget(Request $request) {
//     	$budget = Course::all()->where('id',$request->getId)->first();
// 		// $msg['success'] = "1";
// 		// $msg['message'] = "success";
// 		// $msg['budget'] = [$budget];
// 	   //         	 $msg['deptArray'] = [$Departments];
//     return Response::json($budget);
// 	}

//     public function budgets(Request $request) {
// 	$budget = Course::all();
// 			$msg['success'] = "1";
//            	$msg['message'] = "success";
//            	$msg['budget'] = [$msg];
//    //         	 $msg['deptArray'] = [$Departments];
//     return response()->json(compact('budget'));
// 	}

// }
// 	public function reqtrack(Request $request){
// 		$req = Request::where('user_id',$request->getId)->first();

// 		return response()->json($req);
// 	}

	// public function ppmpview(Request $request){
	// 		$ppmp = PPMP::all();

	// 		return Response::json($ppmp);
	// 	}
}
