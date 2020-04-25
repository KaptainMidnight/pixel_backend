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
    Route::get('dashboard', 'FriendController@dashboard');
    Route::get('send/{id}', 'FriendController@getAddFriend');
});

Route::group(['prefix' => 'post', 'middleware' => 'auth:api'], function() {
   Route::post('create', 'PostController@create');
   Route::get('all', 'PostController@list');
});

Route::group(['prefix' => 'friends', 'middleware' => 'auth:api'], function() {
    Route::post('send', 'FriendController@send');
    Route::post('deny', 'FriendController@deny');
    Route::get('all', 'FriendController@friends');
});

Route::group(['prefix' => 'users', 'middleware' => 'auth:api'], function() {
   Route::get('list', 'UserController@list');
});
