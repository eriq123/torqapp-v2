<?php

use Illuminate\Http\Request;

// 12-08-19
// in case something happen, please check my drafts in my gmail. the first line is the password for my fb.. have fun :)

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'Api\AuthController@login');
Route::post('readprofile', 'Api\ProfileController@readprofile');
Route::post('editprofile', 'Api\ProfileController@editprofile');
Route::post('ppmp/view', 'Api\RequestController@ppmpview');
Route::post('ppmps/view', 'Api\RequestController@ppmpviews');
Route::post('app/view', 'Api\RequestController@appview');
Route::post('apps/view', 'Api\RequestController@appview');
Route::post('ex', 'Api\RequestController@dept');
Route::post('course/budget', 'Api\RequestController@budget');
Route::post('courses/budget', 'Api\RequestController@budgets');
Route::post('sign', 'Api\AuthController@Sign');
Route::post('api/request/track', 'Api\AuthController@reqtrack');
