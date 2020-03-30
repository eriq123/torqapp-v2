<?php

namespace App\Http\Controllers;

use App\Course;
use App\Item;
use App\RequestItems;
use Auth;
use Illuminate\Http\Request;

class ReportsController extends Controller
{

    public function section(Request $request){
    	$course = Course::findorFail(Auth::user()->course_id);

    	$supplies = Item::with('app')->where([['status','!=','ForRevision'],['category','Supplies']])->get();
    	$equipment = Item::with('app')->where([['status','!=','ForRevision'],['category','Equipment']])->get();

        $SuppliesTotal = 0;
        $EquipmentTotal = 0;
        $SupplementalTotal = 0;


		foreach ($supplies as $k => $v) {
			$r_supplies = RequestItems::where('item_id',$v->id)->first();
			if ($r_supplies) {
				if ($r_supplies->status == "Fulfilled") {

			    	if($v->app->type == "Supplemental"){
		    			$SupplementalTotal += $r_supplies->total;
		    		}elseif($v->app->type == "Supplies/Equipment"){
		    			$SuppliesTotal += $r_supplies->total;
		    		}

				}else{

			    	if($v->app->type == "Supplemental"){
		    			$SupplementalTotal += $v->total;
		    		}elseif($v->app->type == "Supplies/Equipment"){
		    			$SuppliesTotal += $v->total;
		    		}

				}
			}

    	}

		foreach ($equipment as $k => $v) {
			$r_equipment = RequestItems::where('item_id',$v->id)->first();

			if($r_equipment){
				if ($r_equipment == "Fulfilled") {
			    	
			    	if($v->app->type == "Supplemental"){
		    			$SupplementalTotal += $r_equipment->total;
		    		}elseif($v->app->type == "Supplies/Equipment"){
		    			$EquipmentTotal += $r_equipment->total;
		    		}

				}else{

			    	if($v->app->type == "Supplemental"){
		    			$SupplementalTotal += $v->total;
		    		}elseif($v->app->type == "Supplies/Equipment"){
		    			$EquipmentTotal += $v->total;
		    		}

				}
			}
    	}

    	$total = array(
    		'supplies' => $SuppliesTotal, 
    		'equipment' => $EquipmentTotal, 
    		'supplemental' => $SupplementalTotal, 
    	);

    	return response()->json(compact('course','supplies','equipment','total'));
    }

    
}
