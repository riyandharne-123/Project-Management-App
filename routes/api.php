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


Route::post('/login','Api\UserController@login')->name('login');
Route::post('/register','Api\UserController@register')->name('register');

Route::group(['middleware' => ['auth:api'], 'namespace' => 'Api'],function(){
    Route::get('/verify_user','UserController@verify');
    Route::resource('projects','ProjectController');
    Route::resource('tasks','TaskController');
    Route::post('/tasks/update/{id}','TaskController@update_task');
    Route::post('/update/position','TaskController@update_postion');
    Route::post('/project/tasks','TaskController@get_all');
});