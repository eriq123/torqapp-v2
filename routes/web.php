<?php

use App\Notifications\PpmpSendNotification;
use App\User;
use Illuminate\Support\Facades\Notification;

Auth::routes(['reset'=>false]);
Route::post('registers', 'Auth\RegisterController@dropdown')->name('dropdown');

// this is where we get the initial data to test the request
Route::post('/sample','SampleData@index')->name('sample.data');

Route::get('/send', 'SampleData@send');
Route::get('markasread', 'SampleData@markasread');

Route::group(['middleware' => ['auth','web']], function () 
{
	Route::name('main.')->group(function () {

		// all user index
		Route::get('/','MainController@index')->name('index');

		// all user profile
		Route::get('/Profile','MainController@profile')->name('profile');
		Route::post('/Profile','MainController@submit_profile')->name('submit_profile');
		Route::post('/Profile/Password','MainController@password')->name('password');
		Route::post('/Profile/Signature','MainController@signature')->name('signature');

	});

	// if admin
	Route::group(['middleware' => ['role:Admin']], function () {
		Route::name('admin.')->group(function () {

			// department crud
			Route::get('/Admin/Department','AdminController@department')->name('department');
			Route::post('/Admin/Department/crud','AdminController@department_crud')->name('department_crud');

			// course crud
			Route::get('/Admin/Course','AdminController@course')->name('course');
			Route::post('/Admin/Course/crud','AdminController@course_crud')->name('course_crud');

			// manage account 
			Route::get('/Admin/Account','AdminController@account')->name('account');
			Route::post('/Admin/Account/actions','AdminController@account_actions')->name('account_actions');

		});
	});

	// if budget
	Route::group(['middleware' => ['role:Budget Officer']], function () {
		Route::name('budget.')->group(function () {

			// allocation
			Route::get('/Budget/Allocation','BudgetController@allocation')->name('allocation');
			Route::post('/Budget/Allocation/actions','BudgetController@allocation_actions')->name('allocation_actions');

			// ppmp crud
			Route::get('/Budget/Ppmp/{type}','BudgetController@ppmp_list')->name('ppmp_list');
			Route::post('/Budget/Ppmp/crud','BudgetController@ppmp_crud')->name('ppmp_crud');

			// items crud
			Route::get('/Budget/Ppmp/{type}/id/{id}','BudgetController@items_list')->name('items_list');
			Route::post('/Budget/Ppmp/items_crud','BudgetController@items_crud')->name('items_crud');

		});
	});

	// if section head
	Route::group(['middleware' => ['role:Section Head']], function () {
		Route::name('section.')->group(function () {
			
			// ppmp crud
			Route::get('/SH/Ppmp/{type}','SectionController@ppmp_list')->name('ppmp_list');
			Route::post('/SH/Ppmp/crud','SectionController@ppmp_crud')->name('ppmp_crud');

			// items crud
			Route::get('/SH/Ppmp/{type}/id/{id}','SectionController@items_list')->name('items_list');
			Route::post('/SH/Ppmp/items_crud','SectionController@items_crud')->name('items_crud');

			//request
			Route::get('/SH/RL/select/app','SectionController@select_app')->name('select_app');
			Route::get('/SH/RL/app/{id}','SectionController@request_add')->name('request_add');
			Route::post('/SH/RL/crud','SectionController@request_crud')->name('request_crud');

			//progress
			Route::get('/SH/RL_tracker/','SectionController@progress_list')->name('progress_list');

			// reports
			Route::post('/Reports/section_head','ReportsController@section')->name('reports');

		});
	});

	// if ADAA
	Route::group(['middleware' => ['role:ADAA']], function () {
		Route::name('adaa.')->group(function () {
			
			// ppmp crud
			Route::get('/ADAA/Ppmp/{type}','ADAAController@ppmp_list')->name('ppmp_list');
			Route::post('/ADAA/Ppmp/crud','ADAAController@ppmp_crud')->name('ppmp_crud');

			// items crud
			Route::get('/ADAA/Ppmp/{type}/id/{id}','ADAAController@items_list')->name('items_list');
			Route::post('/ADAA/Ppmp/items_crud','ADAAController@items_crud')->name('items_crud');

		});
	});

	// if Campus Director
	Route::group(['middleware' => ['role:Campus Director']], function () {
		Route::name('director.')->group(function () {
			
			// ppmp crud
			Route::get('/Director/Ppmp/{type}','DirectorController@ppmp_list')->name('ppmp_list');
			Route::post('/Director/Ppmp/crud','DirectorController@ppmp_crud')->name('ppmp_crud');

			// items crud
			Route::get('/Director/Ppmp/{type}/id/{id}','DirectorController@items_list')->name('items_list');
			Route::post('/Director/Ppmp/items_crud','DirectorController@items_crud')->name('items_crud');

		});
	});

	Route::name('print.')->group(function () {

		// print
		Route::post('/Print/ppmp/','PrintController@ppmp')->name('ppmp');
	
	});


	// APP
	Route::name('app.')->group(function () {

		// app crud
		Route::get('/App/{type}','APPController@app_list')->name('list');
		Route::post('/App/crud','APPController@app_crud')->name('crud');

	});

	// PPMP global view
	Route::name('view.')->group(function () {

		// ppmp crud
		Route::get('/PPMP/{type}','ViewController@ppmp_list')->name('ppmp_list');
		Route::get('/Ppmp/{type}/id/{id}','ViewController@items_list')->name('items_list');

	});
	
	// request approval
	Route::name('requests.')->group(function () {
		Route::post('/RL/modal/view','RequestsController@modal_view')->name('modal_view');
		Route::post('/RL_tracker/crud','RequestsController@progress_crud')->name('progress_crud');

		Route::get('/RL/list','RequestsController@requests_list')->name('list');
		Route::post('/RL/crud','RequestsController@requests_crud')->name('crud');
		Route::get('/RL/list/{id}','RequestsController@supplies_view')->name('supplies_view');
	});

});


