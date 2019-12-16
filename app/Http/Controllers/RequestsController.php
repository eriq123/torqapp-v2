<?php

namespace App\Http\Controllers;

use App\App;
use App\Course;
use App\Item;
use App\Notifications\RequestNotification;
use App\Progress;
use App\RequestItems;
use App\RequestItemsLine;
use App\Requests;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class RequestsController extends Controller
{

	public function modal_view(Request $request){
		if ($request->ajax()) {
			if ($request->submit == "progress_view_status") {
				$req = Requests::findorfail($request->id);
				$custom_id = $req->custom_id;
				$progress = Progress::where('request_id',$request->id)->get();
				$last_progress = Progress::where('request_id',$request->id)->orderBy('id','desc')->first();

				$app = App::findorfail($req->app_id);
				$app_custom_id = $app->custom_id;
				
				$items = RequestItems::with('item')->with('request_items_line')->where('request_id',$req->id)->get();

				return response()->json(compact('req','custom_id','progress','last_progress','app','app_custom_id','items'));
			}elseif ($request->submit == "supplies_modal") {
				$items = RequestItems::with('item')->findorfail($request->id);

				return response()->json(compact('items'));
			}elseif ($request->submit == "logs_modal_btn") {
				$items = RequestItems::with('item')->with('request_items_line')->findorfail($request->id);

				return response()->json(compact('items'));
			}
		}
	}

	public function progress_crud(Request $request){
		if ($request->get('submit') == "print") {
			$req = Requests::findorfail($request->get('id'));

			return view('section.progress.print',compact('req'));
		}elseif ($request->get('submit') == "download") {
			$req = Requests::findorfail($request->get('id'));
			if ($req->attachment['file_name']) {
				$file_name = public_path() . '/TORQAPP/attachments/'.$req->attachment['file_name'];
				$original_name = $req->attachment['original_name'];

				return response()->download($file_name,$original_name);
			}
		}

	}

    public function requests_list(){
		$requests = Requests::with('progress')->orderBy('id','desc')->get();

    	return view('requests.list',compact('requests'));
    }

    public function supplies_view($id){
		$req = Requests::findorfail($id);

		$items = RequestItems::with('item')->with('request_items_line')->where('request_id',$req->id)->get();

		return view('supplies.transfer',compact('items','req'));
    }

    public function requests_crud(Request $request){
		$req = Requests::findorfail($request->get('id'));
		
    	// this is the global request notification
	        $request_data = array(
	        	'type' => "REQUEST",
	            'request_id'=> $req->id,  
	            'description'=> $req->custom_id ." has been updated.",
	        );

        	$section_head = User::findorfail($req->user_id);
    		Notification::send($section_head, new RequestNotification($request_data));

		if ($request->get('submit') == "supplies_transfer") {
			$cost = preg_replace("/[^0-9.]/", "", $request->get('cost'));
			$total = $cost * $request->get('quantity');

    		$items = RequestItems::with('item')->findorfail($request->get('ritem_id'));
    		$items->quantity = $items->quantity + $request->get('quantity'); 

    		// this is the logs of every supplies transfer per item
	    		$ritems_line = new RequestItemsLine();
	    		$ritems_line->request_items_id = $items->id;
	    		$ritems_line->quantity = $request->get('quantity');
	    		$ritems_line->cost = $cost; 
	    		$ritems_line->total = $total;
	    		$ritems_line->save();

    		// if greater than
	    		if ($items->quantity > $items->item->quantity) {
	    			return redirect()->route('requests.supplies_view',['id'=>$req->id])->withErrors("Invalid quantity, please try again.");
	    		}

    		$user = User::findorfail($req->user_id);
    		$course = Course::findorfail($user->course_id);
    		$app = App::findorfail($req->app_id);

    		$progress = new Progress();
    		$progress->request_id = $req->id;

    		// if equal
    		if ($items->quantity == $items->item->quantity) {
	    		// complete
	    		$items->status = "Fulfilled";

	    		// budget computation and reimbursement to course
		    		$ritems_line_loop = RequestItemsLine::where('request_items_id',$items->id)->get();
		    		$ritems_line_total = null;
		    		foreach ($ritems_line_loop as $k => $v) {
		    			$ritems_line_total += $v->total;
		    		}

    				$items->total = $ritems_line_total;

		    		if ($items->total > $items->item->total) {
	    				$difference = $items->total - $items->item->total;
						// deduct to sh course budget

			    		if ($app->type == "Supplemental") {
			    			$course->supplemental = $course->supplemental - $difference;
	    					$progress->status = "An item has been fulfilled. <b>" . $difference . "</b> has been <b>deducted</b> to supplemental budget ";

			    		} elseif ($app->type == "Supplies/Equipment") {
			    			if ($items->item->category == "Supplies") {
			    				$course->supplies = $course->supplies - $difference;
	    						$progress->status = "An item has been fulfilled. <b>" . $difference . "</b> has been <b>deducted</b> to supplies budget ";

			    			}elseif ($items->item->category == "Equipment") {
			    				$course->equipment = $course->equipment - $difference;
	    						$progress->status = "An item has been fulfilled. <b>" . $difference . "</b> has been <b>deducted</b> to equipment budget ";

			    			}
			    		}

		    		}elseif ($items->total < $items->item->total) {
						$difference = $items->item->total - $items->total;
						// add budget to sh course

			    		if ($app->type == "Supplemental") {
			    			$course->supplemental = $course->supplemental + $difference;
    						$progress->status = "An item has been fulfilled. <b>" . $difference . "</b> has been <b>added</b> to supplemental budget ";

			    		} elseif ($app->type == "Supplies/Equipment") {
			    			if ($items->item->category == "Supplies") {
			    				$course->supplies = $course->supplies + $difference;
    							$progress->status = "An item has been fulfilled. <b>" . $difference . "</b> has been <b>added</b> to supplies budget ";

			    			}elseif ($items->item->category == "Equipment") {
			    				$course->equipment = $course->equipment + $difference;
    							$progress->status = "An item has been fulfilled. <b>" . $difference . "</b> has been <b>added</b> to equipment budget ";

			    			}
			    		}

		    		}

		    		$course->save();

			// if less than
    		}else{
    			$items->status = "Partially fulfilled";
	    		$progress->status = "An item has been partially fulfilled. Once the item has been fulfilled, the budget will be adjusted.";

	    	}

    		$progress->office = "Section Head";
    		$progress->save();

    		$items->save();

    		$req->status = "Section Head";
    		$req->save();

    		return redirect()->route('requests.supplies_view',['id'=>$req->id])->withSuccess("Transfer success!");
    	}

    	if ($request->get('submit') == "department_approve") {
    		$req->status = "ADAA";
    		$department_head = $req->department_head;
    		$department_head['comment'] = null;
    		$department_head['signature'] = Auth::user()->signature;
    		$department_head['date'] = Carbon::now()->format('m/d/Y');
    		$req->department_head = $department_head;
    		$req->save();

	        $prog = new Progress();
	        $prog->request_id = $req->id;
	        $prog->status = "sent";
	        $prog->office = "ADAA";
	        $prog->save();

	        // notification
            $recipient = User::findorfail($req->adaa['id']);
        	Notification::send($recipient, new RequestNotification($request_data));

	        return redirect()->back()->withSuccess("Request status updated!");
    	}elseif ($request->get('submit') == "adaa_approve") {
    		$req->status = "Campus Director";
    		$adaa = $req->adaa;
    		$adaa['comment'] = null;
    		$adaa['signature'] = Auth::user()->signature;
    		$adaa['date'] = Carbon::now()->format('m/d/Y');
    		$req->adaa = $adaa;
    		$req->save();

	        $prog = new Progress();
	        $prog->request_id = $req->id;
	        $prog->status = "sent";
	        $prog->office = "Campus Director";
	        $prog->save();

	        // notification
            $recipient = User::findorfail($req->campus_director['id']);
        	Notification::send($recipient, new RequestNotification($request_data));

	        return redirect()->back()->withSuccess("Request status updated!");
    	}elseif ($request->get('submit') == "campus_director_approve") {
    		$req->status = "BAC Secretary";
    		$campus_director = $req->campus_director;
    		$campus_director['comment'] = null;
    		$campus_director['signature'] = Auth::user()->signature;
    		$campus_director['date'] = Carbon::now()->format('m/d/Y');
    		$req->campus_director = $campus_director;
    		$req->save();

	        $prog = new Progress();
	        $prog->request_id = $req->id;
	        $prog->status = "sent";
	        $prog->office = "BAC Secretary";
	        $prog->save();

	        // notification
        	$recipient = User::role('BAC Secretary')->get();
            foreach ($recipient as $key => $value) {
            	Notification::send($value, new RequestNotification($request_data));
            }

	        return redirect()->back()->withSuccess("Request status updated!");
    	}elseif ($request->get('submit') == "needs_revision") {

    		if ($req->status == "Department Head") {
	    		$department_head = $req->department_head;
	    		$department_head['comment'] = $request->get('comment');
	    		$req->department_head = $department_head;
    		}elseif ($req->status == "ADAA") {
	    		$adaa = $req->adaa;
	    		$adaa['comment'] = $request->get('comment');
	    		$req->adaa = $adaa;
    		}elseif ($req->status == "Campus Director") {
	    		$campus_director = $req->campus_director;
	    		$campus_director['comment'] = $request->get('comment');
	    		$req->campus_director = $campus_director;
    		}
	    		$req->save();

    		$last_progress = Progress::where('request_id',$req->id)->orderBy('id','desc')->first();
	        $prog = new Progress();
	        $prog->request_id = $req->id;
	        $prog->status = "needs revision";
	        $prog->office = $last_progress->office;
	        $prog->save();

	        return redirect()->back()->withSuccess("Request status updated!");
    	}elseif ($request->get('submit') == "bac_sec_transfer") {
    		$req->status = "Procurement";
    		// you can also save the details of the bac_sec that transfer this request
    		$req->save();

    		$prog = new Progress();
	        $prog->request_id = $req->id;
	        $prog->status = "sent";
	        $prog->office = "Procurement";
	        $prog->save();

	        // notification
        	$recipient = User::role('Procurement')->get();
            foreach ($recipient as $key => $value) {
            	Notification::send($value, new RequestNotification($request_data));
            }

	        return redirect()->back()->withSuccess("Request status updated!");
    	}elseif ($request->get('submit') == "proc_transfer") {
    		$req->status = "Supplies";
    		// you can also save the details of the proc_officer that transfer this request
    		$req->save();

    		$prog = new Progress();
	        $prog->request_id = $req->id;
	        $prog->status = "sent";
	        $prog->office = "Supplies";
	        $prog->save();

	        // notification
        	$recipient = User::role('Supplies')->get();
            foreach ($recipient as $key => $value) {
            	Notification::send($value, new RequestNotification($request_data));
            }

	        return redirect()->back()->withSuccess("Request status updated!");
    	}

    }

}
