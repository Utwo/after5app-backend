<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['uses' => 'HomeController@index']);

Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->where('provider', 'facebook');
Route::get('auth/{provider}/callback', ['as' => 'api.v1.facebook.callback', 'uses' => 'Auth\AuthController@handleProviderCallback'])->where('provider', 'facebook');
Route::get('auth/email-authenticate/{token}', ['as' => 'auth.email-authenticate', 'uses' => 'Auth\AuthController@authenticateEmail']);

Route::post('auth/login', ['uses' => 'Auth\AuthController@login']);

Route::group(['prefix' => 'api/v1', 'middleware' => ['api']], function () {

    Route::get('project', ['uses' => 'ProjectController@index']);
    Route::get('skill', ['uses' => 'SkillController@index']);
    Route::get('user/{username?}', ['uses' => 'UserController@index']);

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('project', ['uses' => 'ProjectController@store']);
        Route::put('project/{project}', ['uses' => 'ProjectController@update']);
        Route::delete('project/{project}', ['uses' => 'ProjectController@destroy']);

        Route::get('application', ['uses' => 'ApplicationController@index']);
        Route::post('application', ['uses' => 'ApplicationController@store']);
        Route::delete('application/{application}', ['uses' => 'ApplicationController@destroy']);

        Route::post('skill', ['uses' => 'SkillController@store']);
        Route::delete('skill/{skill}', ['uses' => 'SkillController@destroy']);

        Route::post('comment', ['uses' => 'CommentController@store']);
        Route::delete('comment/{comment}', ['uses' => 'CommentController@destroy']);

        Route::put('user', ['uses' => 'UserController@update']);
    });
});

Route::post('token/{user}', function ($id) {
    $user = App\User::findOrFail($id);

    $token = JWTAuth::fromUser($user);
    return response()->json(['jwt-token' => $token]);
});