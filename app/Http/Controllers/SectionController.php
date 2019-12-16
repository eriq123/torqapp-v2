<?php

namespace App\Http\Controllers;

use App\App;
use App\Course;
use App\Item;
use App\Notifications\PpmpNotification;
use App\Notifications\RequestNotification;
use App\Ppmp;
use App\Progress;
use App\RequestItems;
use App\Requests;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Notification;

class SectionController extends Controller
{

	public function request_add($id){
        $directors = User::role('Campus Director')->get();
        $departments = User::role('Department Head')->where('department_id',Auth::user()->department_id)->get();
		$adaas = User::role('ADAA')->get();        
		$app = App::with(['item'=>function($q){$q->where('status','Approved');}])->findorFail($id);

		return view('section.request.add',compact('directors','departments','adaas','app'));
	}


	public function request_crud(Request $request){
		if($request->get('submit') == "add") {
			$request->validate([
				'Rcontent' =>'required',
			],[
				'Rcontent.required' => 'Request content is required.',
			]);
			$req = new Requests();
			$req->user_id = Auth::id();
			$req->app_id = $request->get('app_id');

			$req->date = $request->get('RequestDate');
			$req->content = $request->get('Rcontent');
			$req->status = "Department Head";

			$sh = $req->section_head;
			$sh['name'] = $request->get('sh_name');
			$sh['role'] = $request->get('sh_role');
			if(Auth::user()->signature){
				$sh['signature'] = Auth::user()->signature;
			}
			$req->section_head = $sh;

			$department_detail = User::findorfail($request->get('department_id'));
			$dept = $req->department_head;
			$dept['id'] = $department_detail->id;
			$dept['name'] = $department_detail->full_name;
			$dept['role'] = $request->get('department_role');
			$req->department_head = $dept;

			$adaa_detail = User::findorfail($request->get('adaa_id'));
			$adaa = $req->adaa;
			$adaa['id'] = $adaa_detail->id;
			$adaa['name'] = $adaa_detail->full_name;
			$adaa['role'] = $request->get('adaa_role');
			$req->adaa = $adaa;

			$cd_detail = User::findorfail($request->get('director_id'));
			$cd = $req->campus_director;
			$cd['id'] = $cd_detail->id;
			$cd['name'] = $cd_detail->full_name;
			$cd['role'] = $request->get('director_role');
			$req->campus_director = $cd;

	        // attachment
	        if(!empty($request->file('attachment'))){
	            $attachment = $request->file('attachment');
	            $current = Carbon::now()->format('YmdHs');

	            $extension = $attachment->getClientOriginalExtension();
	            $filename = Auth::user()->id.'-'.$current.'-'.$attachment->getClientOriginalName();
	            Storage::disk('RequestAttachment')->put($filename,  File::get($attachment));
	            

	            if ($filename !== $req->attachment['file_name']) {
	                Storage::disk('RequestAttachment')->delete($req->attachment['file_name']);
	            }
    	   
    	        $save_upload = $req->attachment;
		        $save_upload['file_name'] = $filename;
		        $save_upload['original_name'] = $attachment->getClientOriginalName();
		        $req->attachment = $save_upload;
	        }
	        // end attachment

			$req->save();

			// start here
			$items = explode(",",$request->get('items'));
			foreach ($items as $item_id) {
				$item = Item::findorfail($item_id);
				$item->requested = true;
				$item->save();

				$ritems = new RequestItems();
				$ritems->item_id = $item->id;
				$ritems->request_id = $req->id;
				$ritems->quantity = 0;
				$ritems->total = 0;
				$ritems->status = "To be fulfilled";
				$ritems->save();
			}

			$prog = new Progress();
			$prog->request_id = $req->id;
			$prog->status = "sent";
			$prog->office = "Department Head";
			$prog->save();

			// insert notifications here
	            $request_data = array(
	            	'type' => "REQUEST",
		            'request_id'=> $req->id,  
		            'description'=> $req->custom_id ." has been submitted.",
	            );

            	Notification::send($department_detail, new RequestNotification($request_data));

			return redirect()->route('section.progress_list')->withSuccess("Request Sent!");

		}elseif ($request->get('submit') == "update_view") {
			$req = Requests::findorfail($request->get('id'));

	        $directors = User::role('Campus Director')->get();
	        $departments = User::role('Department Head')->where('department_id',Auth::user()->department_id)->get();
			$adaas = User::role('ADAA')->get();        
			$app = App::with(['item'=>function($q){$q->where('status','Approved');}])->findorFail($req->app_id);

			$items = RequestItems::where('request_id',$req->id)->get();
			$array_of_item_ids = [];

			foreach ($items as $item) {
				if ($item->request_id == $req->id) {
					$array_of_item_ids[] = $item->item_id;
				}
			}

			$item_ids = implode(",", $array_of_item_ids);

			return view('section.request.update',compact('directors','departments','adaas','app','req','item_ids'));

		}elseif ($request->get('submit') == "update") {
			$req = Requests::findorfail($request->get('req_id'));

			$req->date = $request->get('RequestDate');
			$req->content = $request->get('Rcontent');

			$sh = $req->section_head;
			$sh['name'] = $request->get('sh_name');
			$sh['role'] = $request->get('sh_role');
			if(Auth::user()->signature){
				$sh['signature'] = Auth::user()->signature;
			}
			$req->section_head = $sh;

			$department_detail = User::findorfail($request->get('department_id'));
			$dept = $req->department_head;
			$dept['id'] = $department_detail->id;
			$dept['name'] = $department_detail->full_name;
			$dept['role'] = $request->get('department_role');
			$req->department_head = $dept;

			$adaa_detail = User::findorfail($request->get('adaa_id'));
			$adaa = $req->adaa;
			$adaa['id'] = $adaa_detail->id;
			$adaa['name'] = $adaa_detail->full_name;
			$adaa['role'] = $request->get('adaa_role');
			$req->adaa = $adaa;

			$cd_detail = User::findorfail($request->get('director_id'));
			$cd = $req->campus_director;
			$cd['id'] = $cd_detail->id;
			$cd['name'] = $cd_detail->full_name;
			$cd['role'] = $request->get('director_role');
			$req->campus_director = $cd;

	        // attachment
	        if(!empty($request->file('attachment'))){
	            $attachment = $request->file('attachment');
	            $current = Carbon::now()->format('YmdHs');

	            $extension = $attachment->getClientOriginalExtension();
	            $filename = Auth::user()->id.'-'.$current.'-'.$attachment->getClientOriginalName();
	            Storage::disk('RequestAttachment')->put($filename,  File::get($attachment));
	            

	            if ($filename !== $req->attachment['file_name']) {
	                Storage::disk('RequestAttachment')->delete($req->attachment['file_name']);
	            }

		        $save_upload = $req->attachment;
		        $save_upload['file_name'] = $filename;
		        $save_upload['original_name'] = $attachment->getClientOriginalName();
		        $req->attachment = $save_upload;  

	        }

	        $old_request_items = explode(",", $request->get('old_items'));
	        $new_request_items = explode(",", $request->get('items'));

            $items_to_delete = array_diff($old_request_items, $new_request_items);
            $items_to_add = array_diff($new_request_items, $old_request_items);

	        foreach ($items_to_delete as $item_to_delete) {
	        	// this is where we delete items that are no longer part of the new array
				$item = Item::findorfail($item_to_delete);
				$item->requested = false;
				$item->save();

	        	$ritems = RequestItems::where('item_id',$item->id)->first();
	        	$ritems->delete();
	        }

	        foreach ($items_to_add as $item_to_add) {
	        	// this is where we add items that are added from the old array
				$item = Item::findorfail($item_to_add);
				$item->requested = true;
				$item->save();

				$ritems = new RequestItems();
				$ritems->item_id = $item->id;
				$ritems->request_id = $req->id;

				$ritems->quantity = 0;
				$ritems->total = 0;
				$ritems->status = "To be fulfilled";
				$ritems->save();

	        }

			$req->save();

			return redirect()->route('section.progress_list')->withSuccess("Request Updated!");

		}elseif($request->get('submit') == "delete") {
			$delete_ritems = RequestItems::where('request_id',$request->get('id'))->get();
			foreach ($delete_ritems as $d_ritems) {
				$item = Item::findorfail($d_ritems->item_id);
				$item->requested = false;
				$item->save();

				$d_ritems->delete();
			}

			$delete_req = Requests::findorFail($request->get('id'));
			$delete_req->delete();


			return redirect()->back()->withSuccess('Request deleted!');
		}
	}


	public function progress_list(){
		$requests = Requests::with('progress')->where('user_id',Auth::id())->orderBy('id','desc')->get();
		
		return view('section.progress.list',compact('requests'));
	}

//return it back to top later 
	// Ppmp CRUD
	public function ppmp_list($type){
		if ($type == "se") {
			$ppmp_type = "Supplies/Equipment";
		}elseif ($type == "su"){
			$ppmp_type = "Supplemental";
		}

		$ppmps = Ppmp::where([['course_id',Auth::user()->course_id],['type',$ppmp_type]])->get();

		return view('section.ppmp.list',compact('type','ppmp_type','ppmps'));
	}


	public function ppmp_crud(Request $request){
		// ppmp status

		// open
		// submitted
		// approved
		// closed

		if ($request->get('submit') == "add") {
			$ppmp = new Ppmp();
			$ppmp->user_id = Auth::id();
			$ppmp->course_id = Auth::user()->course_id;
			$ppmp->status = "Open";
			$ppmp->course = $request->get('create_course');
			
			$prepared = $ppmp->prepared;
			$prepared['name'] = $request->get('create_name');
			$prepared['signature'] = Auth::user()->signature;
			$prepared['role'] = Auth::user()->getRoleNames()->first();
			$ppmp->prepared = $prepared;

			$ppmp->fiscal_year = $request->get('create_fiscal_year');
			$ppmp->type = $request->get('create_type');
			$ppmp->save();



			if ($ppmp->type == "Supplemental") {
				$type = "su";
			}else{
				$type = "se";
			}
			return redirect()->route('section.ppmp_list',['type'=>$type])->withSuccess('PPMP saved!');
		}elseif ($request->get('submit') == "update") {
			$ppmp = Ppmp::findorFail($request->get('id'));
			$ppmp->course = $request->get('course');
			
			$prepared = $ppmp->prepared;
			$prepared['name'] = $request->get('prepared');
			$prepared['signature'] = Auth::user()->signature;
			$prepared['role'] = Auth::user()->getRoleNames()->first();
			$ppmp->prepared = $prepared;

			$ppmp->fiscal_year = $request->get('fiscal_year');
			$ppmp->save();

			return redirect()->back()->withSuccess('PPMP updated!');
		}elseif ($request->get('submit') == "delete") {
			$ppmp = Ppmp::findorFail($request->get('id'));
			$ppmp->delete();

			return redirect()->back()->withSuccess('PPMP deleted!');
		}elseif ($request->get('submit') == "submit") {

			$ppmp = Ppmp::findorFail($request->get('submit_id'));
			$ppmp->status = "Submitted";

			// insert notifications here
            $data = array(
            	'type' => "PPMP",
	            'ppmp_id'=> $ppmp->id,  
	            'description'=> $ppmp->custom_id ." has been submitted.",
            );

            $adaa = User::role('ADAA')->get();
            foreach ($adaa as $key => $value) {
            	Notification::send($value,new PpmpNotification($data));
            }
			// end notifications
			
			$ppmp->save();

			return redirect()->back()->withSuccess('PPMP submitted!');
		}elseif ($request->get('submit') == "sign") {
			$ppmp = Ppmp::findorFail($request->get('id'));
			$prepared = $ppmp->prepared;
			$prepared['signature'] = Auth::user()->signature;
			$prepared['role'] = Auth::user()->getRoleNames()->first();
			$ppmp->prepared = $prepared;
			$ppmp->save();
			
			if (Auth::user()->signature) {
				return redirect()->back()->withSuccess('PPMP signed!');
			}else{
				return redirect()->back()->withErrors('Please insert a signature first!');
			}
		}
	}


	public function items_list($type, $id){
		$ppmp = PPMP::findorFail($id);
		$items = Item::where('ppmp_id',$id)->get();
		$budget = User::with('course')->where('id',Auth::id())->first();

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

		return view('section.ppmp.items',compact('type','id','items','ppmp','budget','equipment_total','supplies_total'));
	}


	public function items_crud(Request $request){

		$course = Course::findorFail(Auth::user()->course_id);

		if ($request->get('submit') == "delete") {
			$item = Item::findorFail($request->get('id'));
			$ppmp = Ppmp::findorFail($item->ppmp_id);

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

			$item->delete();

			return redirect()->back()->withSuccess('Item deleted!');
		}

		$cost = preg_replace("/[^0-9.]/", "", $request->get('cost'));
		$total = $cost * $request->get('quantity');
		$category = $request->get('category');


		if ($request->get('submit') == "add") {
			$request->validate([
				'schedule_1'=>'required',
			],[
				'schedule_1.required'=>'Schedule field is required.',
			]);

			$ppmp = PPMP::findorFail($request->get('id'));

			if ($ppmp->type == "Supplies/Equipment") {
				if ($category == "Supplies") {
					if ($total > $course->supplies) {
						return redirect()->back()->withErrors("Supplies Budget is insufficient for this action.");
					}else{
						$course->supplies = $course->supplies - $total;
						$course->save();
					}
				}elseif ($category == "Equipment") {
					if ($total > $course->equipment) {
						return redirect()->back()->withErrors("Equipment Budget is insufficient for this action.");
					}else{
						$course->equipment = $course->equipment - $total;
						$course->save();
					}
				}
			}elseif ($ppmp->type == "Supplemental") {
				if ($total > $course->supplemental) {
					return redirect()->back()->withErrors("Supplemental Budget is insufficient for this action.");
				}else{
					$course->supplemental = $course->supplemental - $total;
					$course->save();
				}
			}

			$item = new Item();
			$item->ppmp_id = $request->get('id');

			if($request->get('code')){
				$item->code = $request->get('code');
			}

			$item->category = $category;
			$item->description = $request->get('description');
			$item->quantity = $request->get('quantity');
			$item->unit = $request->get('unit');
			$item->cost = $cost;
			$item->total = $total;
			$item->schedule = $request->get('GetSchedule');
			$item->status = "New";
			$item->save();

			return redirect()->back()->withSuccess('Item saved!');
		}elseif ($request->get('submit') == "update") {
			$request->validate([
				'schedule_2'=>'required',
			],[
				'schedule_2.required'=>'Schedule field is required.',
			]);

			$item = Item::findorFail($request->get('id'));
			$ppmp = Ppmp::findorFail($item->ppmp_id);

			if ($ppmp->type == "Supplies/Equipment") {
				if ($category == "Supplies") {
					if (($item->total - $total) > $course->supplies) {
						return redirect()->back()->withErrors("Supplies Budget is insufficient for this action.");
					}else{
						$course->supplies = $course->supplies - ($total - $item->total);
						$course->save();
					}
				}elseif ($category == "Equipment") {
					if (($item->total - $total) > $course->equipment) {
						return redirect()->back()->withErrors("Equipment Budget is insufficient for this action.");
					}else{
						$course->equipment = $course->equipment - ($total - $item->total);
						$course->save();
					}
				}
			}elseif ($ppmp->type == "Supplemental") {
				if (($item->total - $total) > $course->supplemental) {
					return redirect()->back()->withErrors("Supplemental Budget is insufficient for this action.");
				}else{
					$course->supplemental = $course->supplemental - ($total - $item->total);
					$course->save();
				}
			}

			if($request->get('code')){
				$item->code = $request->get('code');
			}

			$item->category = $category;
			$item->description = $request->get('description');
			$item->quantity = $request->get('quantity');
			$item->unit = $request->get('unit');
			$item->cost = $cost;
			$item->total = $total;
			$item->schedule = $request->get('update_schedule');
			$item->save();

			return redirect()->back()->withSuccess('Item updated!');
		}
	}


	public function select_app(){
		$apps = App::where('status','Approved')->get();

		return view('section.request.select_app',compact('apps'));
	}

}




