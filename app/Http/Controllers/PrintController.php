<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ppmp;

class PrintController extends Controller
{
    public function ppmp(Request $request){

		$ppmp = PPMP::with(['item'=>function($q){
			$q->where('status','Approved');
		}])->findorFail($request->get('id'));

		$Equipment = PPMP::with(['item'=>function($q){
			$q->where([['status','Approved'],['category','Equipment']]);
		}])->findorFail($request->get('id'));

		$Supplies = PPMP::with(['item'=>function($q){
			$q->where([['status','Approved'],['category','Supplies']]);
		}])->findorFail($request->get('id'));


		$total = 0;
		if ($ppmp->item) {
			foreach ($ppmp->item as $items) {
				$total += $items->total;
			}
		}

    	$ADAA = $ppmp->recommended;
    	$Budget = $ppmp->evaluated;
    	$Director = $ppmp->approved;

		return view('section.ppmp.print',compact('ppmp','Equipment','Supplies','total','ADAA','Budget','Director'));
	}
	
}
