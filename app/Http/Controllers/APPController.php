<?php

namespace App\Http\Controllers;

use App\App;
use App\Notifications\AppNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class APPController extends Controller
{
	public function app_list($type){
		if ($type == "se") {
			$app_type = "Supplies/Equipment";
		}elseif ($type == "su"){
			$app_type = "Supplemental";
		}

		if (Auth::user()->RoleName == "BAC Secretary" || Auth::user()->RoleName == "BAC Chairperson" || Auth::user()->RoleName == "Campus Director") {
			$apps = App::where('type',$app_type)->get();
		}else{
			$apps = App::where([['course_id',Auth::user()->course_id],['type',$app_type]])->get();
		}
		
		return view('app.list',compact('type','app_type','apps'));
	}


	public function app_crud(Request $request){

		if ($request->get('submit') == "sign") {

			$app = App::findorFail($request->get('id'));

			if (Auth::user()->RoleName == "BAC Secretary") {
				$prepared = $app->prepared;
				$prepared['name'] = Auth::user()->full_name;
				$prepared['signature'] = Auth::user()->signature;
				$app->prepared = $prepared;
			}elseif (Auth::user()->RoleName == "BAC Chairperson") {
				$recommended = $app->recommended;
				$recommended['name'] = Auth::user()->full_name;
				$recommended['signature'] = Auth::user()->signature;
				$app->recommended = $recommended;
			}elseif (Auth::user()->RoleName == "Campus Director") {
				$approved = $app->approved;
				$approved['name'] = Auth::user()->full_name;
				$approved['signature'] = Auth::user()->signature;
				$app->approved = $approved;

				$app->status = "Approved";
			}


			if (Auth::user()->signature) {
				$app->save();

				// start notification
		        $app_data = array(
		        	'type' => "APP",
		            'app_id'=> $app->id,  
		            'description'=> $app->custom_id ." has been updated.",
		        );

		        $section_head = User::findorfail($app->user_id);
		    	Notification::send($section_head,new AppNotification($app_data));

				if (Auth::user()->RoleName == "BAC Secretary") {

			        $approver = User::role('BAC Chairperson')->get();
			        foreach ($approver as $key => $value) {
			        	Notification::send($value,new AppNotification($app_data));
			        }

				}elseif (Auth::user()->RoleName == "BAC Chairperson") {

			        $approver = User::role('Campus Director')->get();
			        foreach ($approver as $key => $value) {
			        	Notification::send($value,new AppNotification($app_data));
			        }

				}
		        // end notification

				return redirect()->back()->withSuccess('APP signed!');
			}else{
				return redirect()->back()->withErrors('Please insert a signature first!');
			}
		}

		$app = App::with(['item'=>function($q){
			$q->where('status','Approved');
		}])->findorFail($request->get('id'));

		if ($app) {
		$total = 0;
			if ($app->item) {
				foreach ($app->item as $items) {
					$total += $items->total;
				}
			}
		}

		if ($request->get('submit') == "view") {
			return view('app.view',compact('app','total'));
		}elseif ($request->get('submit') == "print") {
			return view('app.print',compact('app','total'));
		}
	}


}
