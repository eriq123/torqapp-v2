<?php

namespace App\Http\Controllers;

use App\App;
use App\Item;
use App\Notifications\AppNotification;
use App\Notifications\PpmpNotification;
use App\Ppmp;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DirectorController extends Controller
{
    // Ppmp approve
	public function ppmp_list($type){
		if ($type == "se") {
			$ppmp_type = "Supplies/Equipment";
		}elseif ($type == "su"){
			$ppmp_type = "Supplemental";
		}

		$ppmps = Ppmp::where([['type',$ppmp_type],['status','!=','Open']])->get();

		return view('director.ppmp.list',compact('type','ppmp_type','ppmps'));
	}


	public function ppmp_crud(Request $request){
		$ppmp = Ppmp::findorFail($request->get('id'));
		$approved = $ppmp->approved;
		$approved['name'] = Auth::user()->full_name;
		$approved['signature'] = Auth::user()->signature;
		$approved['role'] = Auth::user()->getRoleNames()->first();
		$ppmp->approved = $approved;
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

		return view('director.ppmp.items',compact('type','id','items','ppmp','equipment_total','supplies_total'));
	}


	public function items_crud(Request $request){
		
		$ppmp = Ppmp::findorfail($request->get('ppmp_id'));
		$ppmp->status = "Approved";
		$approved = $ppmp->approved;
		$approved['name'] = Auth::user()->full_name;
		$approved['signature'] = Auth::user()->signature;
		$approved['role'] = Auth::user()->getRoleNames()->first();
		$ppmp->approved = $approved;
		$ppmp->save();

		$app = New App();
		$app->ppmp_id = $ppmp->id;
		$app->user_id = $ppmp->user_id;
		$app->course_id = $ppmp->course_id;
		$app->status = "Open";
		$app->course = $ppmp->course;
		$app->type = $ppmp->type;
		$app->fiscal_year = $ppmp->fiscal_year;
		$app->save();

		$id = explode(",",$request->get('id'));

		foreach ($id as $key => $value) {
			$item = Item::findorfail($id[$key]);
			$item->app_id = $app->id;
			$item->status = "Approved";
			$item->save();
		}

		// start notification
        $ppmp_data = array(
        	'type' => "PPMP",
            'ppmp_id'=> $ppmp->id,  
            'description'=> $ppmp->custom_id ." has been updated.",
        );

        $section_head = User::findorfail($ppmp->user_id);
    	Notification::send($section_head,new PpmpNotification($ppmp_data));

        $app_data = array(
        	'type' => "APP",
            'app_id'=> $app->id,  
            'description'=> $app->custom_id ." has been created.",
        );

        $bac_sec = User::role('BAC Secretary')->get();
        foreach ($bac_sec as $key => $value) {
        	Notification::send($value,new AppNotification($app_data));
        }
        // end notification
        
		return redirect()->back()->withSuccess('Items approved!');
	}

}
