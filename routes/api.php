<?php

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

Route::group(['prefix' => 'auth'], function() {
   Route::post('login', 'AuthController@login');
   Route::post('signup', 'AuthController@signup');
   Route::get('me', 'AuthController@show');
   Route::get('refresh', 'AuthController@refresh');
   Route::get('logout', 'AuthController@logout');
});

Route::group(['prefix' => 'friend', 'middleware' => 'auth:api'], function() {
    Route::post('send', 'FriendController@send');
    Route::post('accept', 'FriendController@accept');
    Route::post('pending', 'FriendController@getAllFriendships');
    Route::post('unfriend', 'FriendController@unFriend');
});

Route::group(['prefix' => 'post', 'middleware' => 'auth:api'], function() {
   Route::post('create', 'PostController@create');
   Route::get('list', 'PostController@lilistAuthst');
   Route::get('all', 'PostController@list');
});
