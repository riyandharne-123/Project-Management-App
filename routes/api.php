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
    Route::resource('roles','RoleController');
    Route::get('/verify_user','UserController@verify');
    Route::post('roles/delete','RoleController@deleteAll');
    Route::resource('users','UserController');
});