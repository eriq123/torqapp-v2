<?php

namespace App\Http\Controllers;

use App\Course;
use App\Item;
use App\Notifications\PpmpNotification;
use App\Ppmp;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ADAAController extends Controller
{
	// Ppmp approve
	public function ppmp_list($type){
		if ($type == "se") {
			$ppmp_type = "Supplies/Equipment";
		}elseif ($type == "su"){
			$ppmp_type = "Supplemental";
		}

		$ppmps = Ppmp::where([['type',$ppmp_type],['status','!=','Open']])->get();

		return view('adaa.ppmp.list',compact('type','ppmp_type','ppmps'));
	}


	public function ppmp_crud(Request $request){
		$ppmp = Ppmp::findorFail($request->get('id'));
		$recommended = $ppmp->recommended;
		$recommended['name'] = Auth::user()->full_name;
		$recommended['signature'] = Auth::user()->signature;
		$recommended['role'] = Auth::user()->getRoleNames()->first();
		$ppmp->recommended = $recommended;
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

		return view('adaa.ppmp.items',compact('type','id','items','ppmp','equipment_total','supplies_total'));
	}

	public function items_crud(Request $request){
		$request->validate([
			'id'=>'required',
		],[
			'id.required'=>'Please select atleast one item.',
		]);

		$id = explode(",",$request->get('id'));

		foreach ($id as $key => $value) {
			$item = Item::findorfail($id[$key]);
			$ppmp = Ppmp::findorfail($item->ppmp_id);
			$course = Course::findorfail($ppmp->course_id);

			if ($request->get('submit') == "review") {
				
				$recommended = $ppmp->recommended;
				$recommended['name'] = Auth::user()->full_name;
				$recommended['signature'] = Auth::user()->signature;
				$recommended['role'] = Auth::user()->getRoleNames()->first();
				$ppmp->recommended = $recommended;
				$ppmp->save();

				if ($item->status == "ForRevision") {

					if ($ppmp->type == "Supplies/Equipment") {
						if ($item->category == "Supplies") {
							$course->supplies = $course->supplies - $item->total;
							$course->save();
						}elseif ($item->category == "Equipment") {
							$course->equipment = $course->equipment - $item->total;
							$course->save();
						}
					}elseif ($ppmp->type == "Supplemental") {
						$course->supplemental = $course->supplemental - $item->total;
						$course->save();
					}

				}
				$item->status = "Reviewed";
				$item->comment = null;
			}elseif ($request->get('submit') == "revision") {
				if ($item->status !== "ForRevision") {

					if ($ppmp->type == "Supplies/Equipment") {
						if ($item->category == "Supplies") {
							$course->supplies = $course->supplies + $item->total;
							$course->save();
						}elseif ($item->category == "Equipment") {
							$course->equipment = $course->equipment + $item->total;
							$course->save();
						}
					}elseif ($ppmp->type == "Supplemental") {
						$course->supplemental = $course->supplemental + $item->total;
						$course->save();
					}

				}
				$item->status = "ForRevision";
				$item->comment = $request->get('comment');
			}

			$item->save();
		}
		
		// insert notifications here
        $data = array(
        	'type' => "PPMP",
            'ppmp_id'=> $ppmp->id,  
            'description'=> $ppmp->custom_id ." has been updated.",
        );

        $section_head = User::findorfail($ppmp->user_id);
    	Notification::send($section_head,new PpmpNotification($data));

        $budget = User::role('Budget Officer')->get();
        foreach ($budget as $key => $value) {
        	Notification::send($value,new PpmpNotification($data));
        }
		// end notifications

		if ($request->get('submit') == "review") {

			return redirect()->back()->withSuccess('Items reviewed!');
		}elseif ($request->get('submit') == "revision") {
			
			return redirect()->back()->withSuccess('Item status updated!');
		}
	}
}
