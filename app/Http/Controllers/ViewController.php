<?php

namespace App\Http\Controllers;

use App\Item;
use App\Ppmp;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
	public function ppmp_list($type){
		if ($type == "se") {
			$ppmp_type = "Supplies/Equipment";
		}elseif ($type == "su"){
			$ppmp_type = "Supplemental";
		}

		$ppmps = Ppmp::where([['type',$ppmp_type],['status','!=','Open']])->get();

		return view('view.ppmp.list',compact('type','ppmp_type','ppmps'));
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

		return view('view.ppmp.items',compact('type','id','items','ppmp','equipment_total','supplies_total'));
	}
}
