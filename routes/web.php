<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('auth/{provider}/callback', ['as' => 'auth.callback', 'uses' => 'HomeController@index'])->where('provider', 'facebook|github');
Route::get('auth/email-authenticate', ['as' => 'auth.email.index', 'uses' => 'HomeController@index']);

Route::post('auth/login', ['uses' => 'Auth\AuthController@login']);
Route::post('auth/email-authenticate/{token}', ['as' => 'auth.email.post', 'uses' => 'Auth\AuthController@authenticateEmail']);

Route::post('auth/{provider}/callback', ['as' => 'facebook.callback', 'uses' => 'Auth\AuthController@handleProviderCallback'])->where('provider', 'facebook|github');

Route::post('token/{user}', function ($id) {
    $user = App\User::findOrFail($id);

    $token = JWTAuth::fromUser($user);
    return response()->json(['user' => $user,'jwt-token' => $token]);
});