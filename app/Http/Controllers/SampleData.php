<?php

namespace App\Http\Controllers;

use App\App;
use App\Course;
use App\Item;
use App\Notifications\PpmpNotification;
use App\Ppmp;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SampleData extends Controller
{

	public function send(){
	    $adaa = User::role('ADAA')->get();
	    $data = [
	    	'type' => "PPMP",
	        'ppmp_id'=>"1",  
	        'description'=>"This is the message that will be passed to ADAA from SH.",
	    ];
	    // return dd(json_encode($data));
	    // return dd($data);
	    $encoded = json_encode($data);
	    foreach ($adaa as $key => $value) {
	        $not = Notification::send($value,new PpmpNotification($data));
	    }
	    return "this is where i send sample notification";
	}
	
    public function index(){
    	$section_head_signature = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMTk2IiBoZWlnaHQ9IjExNyI+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjMiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBkPSJNIDEyIDUgYyAwIDEuNyAwLjg2IDY1LjM0IDAgOTcgYyAtMC4xMyA0LjY3IC0zIDE0IC0zIDE0Ii8+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjMiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBkPSJNIDcwIDEyIGMgLTAuMjEgMC4xNCAtNy44IDUuNTggLTEyIDggYyAtNC41NiAyLjYzIC05LjEgNC42OSAtMTQgNyBjIC03LjU2IDMuNTcgLTE0LjYzIDcuMTUgLTIyIDEwIGMgLTIuODEgMS4wOSAtNi4zMyAwLjg1IC05IDIgYyAtNC4wMyAxLjczIC0xMC4zIDQuOTYgLTEyIDcgYyAtMC42NiAwLjc5IDAuOSAzLjkgMiA1IGMgMy4wNyAzLjA3IDcuNzQgNi40MiAxMiA5IGMgNi43MyA0LjA4IDEzLjYzIDcuNzUgMjEgMTEgYyAxOC44MSA4LjMxIDM4LjYzIDE2LjQ1IDU2IDIzIGwgNSAwIi8+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjMiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBkPSJNIDE5NSAyNCBjIDAgLTAuMjQgMC40MiAtOS41NSAwIC0xNCBjIC0wLjIyIC0yLjMxIC0xLjA0IC01LjI3IC0yIC03IGMgLTAuNDggLTAuODYgLTIgLTEuOTQgLTMgLTIgYyAtNC4xNiAtMC4yMyAtMTAuMzUgLTAuMTMgLTE1IDEgYyAtNy4yNSAxLjc2IC0xNC44MiA0Ljg5IC0yMiA4IGMgLTUuMjIgMi4yNiAtMTAuNDEgNC44OCAtMTUgOCBjIC00LjYgMy4xMiAtOS40MiA3LjA0IC0xMyAxMSBjIC0yLjQ1IDIuNzEgLTQuNzggNi42OSAtNiAxMCBjIC0wLjk1IDIuNTcgLTEgNS45OCAtMSA5IGMgMCA4LjM0IDAuMjkgMTYuNzEgMSAyNSBjIDAuMjkgMy4zOCAxLjAzIDYuODggMiAxMCBjIDAuNjQgMi4wNSAxLjc3IDQuMjIgMyA2IGMgMS42OSAyLjQ1IDMuODggNC44OCA2IDcgYyAxLjE1IDEuMTUgMi41NyAyLjM0IDQgMyBjIDIuNzEgMS4yNSA1LjkyIDIuMTkgOSAzIGMgMy4zMiAwLjg3IDYuNjYgMS43NCAxMCAyIGMgNS4yMyAwLjQgMTEuMjcgMC45OCAxNiAwIGMgNC4yMyAtMC44OCA5LjQyIC0zLjc2IDEzIC02IGwgMyAtNCIvPjwvc3ZnPg==";
    	
    	// create an approved ppmp
    	$ppmp = new Ppmp();
		$ppmp->user_id = Auth::id();
		$ppmp->course_id = Auth::user()->course_id;
		$ppmp->status = "Approved";
		$ppmp->course = "Computer Engineering Technology";
		
		$prepared = $ppmp->prepared;
		$prepared['name'] = Auth::user()->full_name;
		$prepared['signature'] = $section_head_signature;
		$prepared['role'] = Auth::user()->getRoleNames()->first();
		$ppmp->prepared = $prepared;

		$ppmp->fiscal_year ="2019-2020";
		$ppmp->type = "Supplies/Equipment";
		$ppmp->save();

		// create an approved app
		$app = New App();
		$app->ppmp_id = $ppmp->id;
		$app->user_id = $ppmp->user_id;
		$app->course_id = $ppmp->course_id;
		$app->status = "Approved";
		$app->course = $ppmp->course;
		$app->type = $ppmp->type;
		$app->fiscal_year = $ppmp->fiscal_year;
		$app->save();

		// insert ppmp_items
		for ($i=$ppmp->id; $i < 6; $i++) { 
			$cost = preg_replace("/[^0-9.]/", "", "5000.00");
			$total = $cost * 10;

			$item = new Item();
			$item->ppmp_id = $ppmp->id;
			$item->category = "Supplies";
			$item->description = "Monitor " . $i;
			$item->quantity = 10;
			$item->unit = "pcs";
			$item->cost = $cost;
			$item->total = $total;
			$item->schedule = "Jan";
			$item->status = "New";
			$item->requested = false;
			$item->save();

			// deduct the total to budget
			$course = Course::findorfail($ppmp->course_id);
			$course->supplies = $course->supplies - $item->total;
			$course->save();

				// approve all items
				$add_app_id_to_item = Item::findorfail($item->id);
				$add_app_id_to_item->app_id = $app->id;
				$add_app_id_to_item->status = "Approved";
				$add_app_id_to_item->save();
		} //endfor
		


	return redirect()->back()->withSuccess("sample data has been saved!");
    } //endindex function

    public function markasread(){
    	Auth::user()->unreadNotifications->markAsRead();
    }
}
