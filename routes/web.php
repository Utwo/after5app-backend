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

Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->where('provider', 'facebook');
Route::get('auth/{provider}/callback', ['as' => 'api.v1.facebook.callback', 'uses' => 'Auth\AuthController@handleProviderCallback'])->where('provider', 'facebook');
Route::get('auth/email-authenticate/{token}', ['as' => 'auth.email-authenticate', 'uses' => 'Auth\AuthController@authenticateEmail']);

Route::post('auth/login', ['uses' => 'Auth\AuthController@login']);

Route::post('token/{user}', function ($id) {
    $user = App\User::findOrFail($id);

    $token = JWTAuth::fromUser($user);
    return response()->json(['user' => $user,'jwt-token' => $token]);
});