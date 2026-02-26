<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//學生院api
Route::post('stcollegeapi','student_controller@student_college_api');

//休學院api
Route::post('asc','student_controller@s_suspension_college_Api');
Route::post('asc2','student_controller@s_suspension_college_Api2');
Route::post('asc3','student_controller@s_suspension_college_Api3');
Route::post('asc4','student_controller@s_suspension_college_Api4');
Route::post('asc5','student_controller@s_suspension_college_Api5');
Route::post('asc6','student_controller@s_suspension_college_Api6');
//退學院api
Route::post('adp','student_controller@s_dropout_college_Api');
Route::post('adp2','student_controller@s_dropout_college_Api2');
Route::post('adp3','student_controller@s_dropout_college_Api3');
Route::post('adp4','student_controller@s_dropout_college_Api4');
Route::post('adp5','student_controller@s_dropout_college_Api5');
//教師院api
Route::post('atc','teacher_controller@teacher_college_api');
//師生比
Route::post('tprcollege','TprController@collegeapi');
Route::post('tpr','TprController@department_api');