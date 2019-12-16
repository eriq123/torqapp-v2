<?php

namespace App\Http\Controllers;

use App\Course;
use App\Department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function department(){

    	$departments = Department::all();

    	return view('admin.department',compact('departments'));
    }


    public function department_crud(Request $request){
    	$action = $request->get('action');
    	$name = $request->get('name');

    	if ($action == "add") {

	    	$department = new Department();
    		$department->department_name = $name;
    		$department->save();

    		return redirect()->back()->withSuccess('Department saved!');
    	}elseif($action == "update"){

    		$department = Department::findorFail($request->get('id'));
    		$department->department_name = $name;
    		$department->save();

    		return redirect()->back()->withSuccess('Department updated!');
    	}elseif($action == "delete"){

    		$department = Department::findorFail($request->get('id'));
    		$department->delete();

    		return redirect()->back()->withSuccess('Department deleted!');
    	}
    }


    public function course(){
    	$departments = Department::all();
    	$courses = Course::all();

    	return view('admin.course',compact('courses','departments'));
    }


    public function course_crud(Request $request){
    	$action = $request->get('action');

    	if ($action == "add") {

            $request->validate([
                'department'=>'required',
            ]);

    		$course = new Course();
    		$course->department_id = $request->get('department');
    		$course->course_name = $request->get('name');
    		$course->save();

    		return redirect()->back()->withSuccess('Course saved!');
    	}elseif ($action == "update") {

    		$course = Course::findorFail($request->get('id'));
    		$course->course_name = $request->get('name');
    		$course->save();

    		return redirect()->back()->withSuccess('Course updated!');
    	}elseif ($action == "delete") {
    		
    		$course = Course::findorFail($request->get('id'));
    		$course->delete();

    		return redirect()->back()->withSuccess('Course deleted!');
    	}
    }


    public function account(){
        // return User::whereHas("roles", function($q){ $q->where("name", "Admin"); })->get();

        $users = User::all();
        $departments = Department::all();
        $courses = Course::all();
        $roles = Role::all();

        return view('admin.account',compact('users','departments','courses','roles'));
    } 


    public function account_actions(Request $request){
        $user = User::findorFail($request->get('id'));

        if ($request->get('submit') == "activate") {

            $user->active = 1;
            $user->save();
            return redirect()->back()->withSuccess('Account activated!');

        }elseif ($request->get('submit') == "deactivate") {

            $user->active = 0;
            $user->save();
            return redirect()->back()->withSuccess('Account deactivated!');

        }elseif ($request->get('submit') == "PasswordReset") {

            $user->password = bcrypt('123456');
            $user->save();
            return redirect()->back()->withSuccess('123456 is the new password!');
        }
        elseif ($request->get('submit') == "update") {
                if ($request->get('role') == "2") { // department head
                    $request->validate([
                        'department'=>'required',
                        'role'=>'required',
                    ]);
                }elseif ($request->get('role') == "3") { // section head
                    $request->validate([
                        'department'=>'required',
                        'course'=>'required',
                        'role'=>'required',
                    ]);
                }else{
                    $request->validate([
                        'role'=>'required',
                    ]);
                }
            

            $user->removeRole($request->get('old_role'));
            $user->assignRole($request->get('role'));

            $user->department_id = $request->get('department');
            $user->course_id = $request->get('course');
            $user->save();

            return redirect()->back()->withSuccess('User information updated!');
        }
    }

}
