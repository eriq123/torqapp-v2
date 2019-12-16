<?php

namespace App\Http\Controllers;

use App\Course;
use App\Department;
use App\Item;
use App\Notifications\PpmpNotification;
use App\Ppmp;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class BudgetController extends Controller
{
	public function allocation(){
		$courses = Course::orderBy('course_name','asc')->get();

		return view('budget.allocation',compact('courses'));
	}


	public function allocation_actions(Request $request){

		$action = $request->get('action');

		if ($action == "allocate") {

			$supplies = preg_replace("/[^0-9.]/", "", $request->get('supplies'));
			$equipment = preg_replace("/[^0-9.]/", "", $request->get('equipment'));
			$supplemental = preg_replace("/[^0-9.]/", "", $request->get('supplemental'));

			$course = Course::findorFail($request->get('id'));
			$course->supplies = $supplies;
			$course->equipment = $equipment;
			$course->supplemental = $supplemental;
			$course->save();
		}

		return redirect()->back()->withSuccess('Budget allocated!');
	}

	
	// Ppmp approve
	public function ppmp_list($type){
		if ($type == "se") {
			$ppmp_type = "Supplies/Equipment";
		}elseif ($type == "su"){
			$ppmp_type = "Supplemental";
		}

		$ppmps = Ppmp::where([['type',$ppmp_type],['status','!=','Open']])->get();

		return view('budget.ppmp.list',compact('type','ppmp_type','ppmps'));
	}


	public function ppmp_crud(Request $request){
		$ppmp = Ppmp::findorFail($request->get('id'));
		$evaluated = $ppmp->evaluated;
		$evaluated['name'] = Auth::user()->full_name;
		$evaluated['signature'] = Auth::user()->signature;
		$evaluated['role'] = Auth::user()->getRoleNames()->first();
		$ppmp->evaluated = $evaluated;
		$ppmp->save();

		if (Auth::user()->signature) {
			return redirect()->back()->withSuccess('PPMP signed!');
		}else{
			return redirect()->back()->withErrors('Please insert a signature first!');
		}
	}


	public function items_list($type, $id){

		$ppmp = Ppmp::findorFail($id);
		$items = Item::where('ppmp_id',$id)->get();

		// get the totals
		$supplies_total = 0;
	    $equipment_total = 0;

	    $supplies = $items->where('category','Supplies')->where('status','!=','ForRevision');
	    $equipment = $items->where('category','Equipment')->where('status','!=','ForRevision');

	    if($supplies){
	    	foreach ($supplies as $key => $value) {
	    		// remove for revision items
	    		$supplies_total += $supplies[$key]->total;
	    	}
	    }

	    if($equipment){
	    	foreach ($equipment as $key => $value) {
	    		// remove for revision items
	    		$equipment_total += $equipment[$key]->total;
	    	}
	    }

		return view('budget.ppmp.items',compact('type','id','items','ppmp','equipment_total','supplies_total'));
	}


	public function items_crud(Request $request){

		$id = explode(",",$request->get('id'));


		foreach ($id as $key => $value) {
			$item = Item::findorfail($id[$key]);
			$item->status = "Evaluated";
			$item->save();
		}

		$ppmp = Ppmp::findorFail($request->get('ppmp_id'));
		$evaluated = $ppmp->evaluated;
		$evaluated['name'] = Auth::user()->full_name;
		$evaluated['signature'] = Auth::user()->signature;
		$evaluated['role'] = Auth::user()->getRoleNames()->first();
		$ppmp->evaluated = $evaluated;
		$ppmp->save();

		// insert notifications here
        $data = array(
        	'type' => "PPMP",
            'ppmp_id'=> $ppmp->id,  
            'description'=> $ppmp->custom_id ." has been updated.",
        );

        $section_head = User::findorfail($ppmp->user_id);
    	Notification::send($section_head,new PpmpNotification($data));

        $campus_director = User::role('Campus Director')->get();
        foreach ($campus_director as $key => $value) {
        	Notification::send($value,new PpmpNotification($data));
        }
		// end notifications
		
		return redirect()->back()->withSuccess('Items evaluated!');
	}
}
