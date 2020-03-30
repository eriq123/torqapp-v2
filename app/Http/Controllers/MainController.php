<?php

namespace App\Http\Controllers;

use App\Course;
use App\Notifications\AppNotification;
use App\Notifications\PpmpNotification;
use App\App;
use App\Ppmp;
use App\Requests;
use App\User;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
class MainController extends Controller
{

    // reports
        public function submitted_ppmp($status){
            return PPMP::where('status',$status)->get();
        }

        public function approve_request($status){
            return Requests::where('status',$status)->get();
        }

    public function index(){

    	if(Auth::user()->hasRole('Admin')){
    		return view('admin.content');
    	}
    	elseif(Auth::user()->hasRole('Section Head')) //request report and etc
        {
            return view('section.content');
        }
        elseif(Auth::user()->hasRole('Budget Officer')) //done
        {
            $courses = Course::all();

            return view('budget.content',compact('courses'));
        }
        elseif(Auth::user()->hasRole('ADAA')) //done 
        {
            $ppmps = $this->submitted_ppmp("Submitted");
            $requests = $this->approve_request("ADAA");

            return view('adaa.content',compact('ppmps','requests'));
        }
        elseif(Auth::user()->hasRole('Campus Director')) //done
        {
            $ppmps = $this->submitted_ppmp("Submitted");

            $bac_chairperson_approved = App::where('recommended','!=',null)->get();
            $apps = $bac_chairperson_approved->where('approved',null);

            $requests = $this->approve_request("Campus Director");

            return view('director.content',compact('ppmps','requests','apps'));
        }
        elseif(Auth::user()->hasRole('BAC Secretary')) //done
        {
            $apps = App::where('prepared',null)->get();
            $requests = $this->approve_request("BAC Secretary");

            return view('bac_sec.content',compact('apps','requests'));
        }
        elseif(Auth::user()->hasRole('BAC Chairperson')) //done
        {
            $bac_sec_approved = App::where('prepared','!=',null)->get();
            $apps = $bac_sec_approved->where('recommended',null);

            return view('bac_chairperson.content',compact('apps'));
        }
        elseif(Auth::user()->hasRole('Department Head')) //done
        {
            $courses = Course::where('department_id',Auth::user()->department_id)->get();
            $requests = $this->approve_request("Department Head");

            return view('department.content',compact('courses','requests'));
        }
        elseif(Auth::user()->hasRole('Procurement')) //done
        {
            $requests = $this->approve_request("Procurement");

            return view('procurement.content',compact('requests'));
        }
        elseif(Auth::user()->hasRole('Supplies')) //done
        {
            $requests = $this->approve_request("Supplies");

            return view('supplies.content',compact('requests'));
        }
    	else
    	{
    		return Auth::user()->getRoleNames() + "View is not created yet!";
    	}

    }
    // end index

    // profile
    public function profile(){
        return view('profile.content');
    }
    // end profile

    // account signature
    public function signature(Request $request){

        $user = Auth::User();
        $user->signature = $request->jsig;
        $user->save();

        return response()->json(compact('user'));
    }
    // end account signature

    // submit personal information update
    public function submit_profile(Request $request){
        // return dd($request->all());
        $request->validate([
            'Title'=>'string',
        ]);
        $user = Auth::User();
        $user->title = $request->get('Title');
        $user->first_name = $request->get('profileFirstName');
        $user->last_name = $request->get('profileLastName');
        
        // image
        if(!empty($request->file('image'))){
            $attachment = $request->file('image');
            $current = Carbon::now()->format('YmdHs');

            $extension = $attachment->getClientOriginalExtension();
            $filename = Auth::user()->id.'-'.$current.'-'.$attachment->getClientOriginalName();
            Storage::disk('AccountImage')->put($filename,  File::get($attachment));
            

            if ($filename !== $user->profile_image) {
                Storage::disk('AccountImage')->delete($user->profile_image);
            }
                
        }else{
            $filename = $user->profile_image;
        }
        // end image
        $user->profile_image = $filename;

        $user->save();

        return redirect()->back()->withSuccess("Personal information updated!");
    }
    // end

    // change password and username
    public function password(Request $request){
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->withErrors("Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current_password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->withErrors("New Password cannot be same as your current password. Please choose a different password.");
        }

        $request->validate([
            'new-password' => 'string|min:6|confirmed',
        ],[
            'new-password.min' => 'The new password must be at least 6 characters.',
            'new-password.confirmed' => 'The new password confirmation does not match',
        ]);

        $user = Auth::user();
        $user->username = $request->get('username');
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->withSuccess("Account details updated!");
    }
    // end change password and username




}
