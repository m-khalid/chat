<?php

use Illuminate\Http\Request;

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
Route::post('register','UserController@store');
Route::post('login','UserController@get');
Route::post('editprofile','UserController@update');
Route::post('viewprofile','UserController@display');
Route::post('changepassword','UserController@changepassword');
Route::post('request','RequestController@request');
Route::post('search','SearchController@search');
Route::post('img','ImgController@setimg');
Route::post('block','BlockController@block');
Route::post('cancelblock','BlockController@cancel');
Route::post('acceptedrequest','FriendController@added');
Route::post('listaccepted','FriendController@list_accepted');
Route::post('countaccepted','FriendController@count_accept');