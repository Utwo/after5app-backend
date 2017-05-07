<?php

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


Route::post('auth/login', ['uses' => 'Auth\AuthController@login']);
Route::post('auth/email-authenticate/{token}', ['as' => 'auth.email.post', 'uses' => 'Auth\AuthController@authenticateEmail']);

Route::post('auth/{provider}/callback', ['as' => 'provider.callback', 'uses' => 'Auth\AuthController@handleProviderCallback'])->where('provider', 'facebook|github');


Route::group(['prefix' => 'v1'], function () {

    Route::get('project', ['uses' => 'ProjectController@index'])->middleware(['jwt.optional']);
    Route::get('project/{project}/comment', ['uses' => 'CommentController@index']);
    Route::get('project/{project}/members', ['uses' => 'ProjectController@members']);
    Route::get('skill', ['uses' => 'SkillController@index']);
    Route::get('user/{user?}', ['uses' => 'UserController@index'])->middleware(['jwt.optional']);

    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('notification/count', ['uses' => 'NotificationController@notification_count']);
        Route::get('notification', ['uses' => 'NotificationController@index']);
        Route::get('project/{project}/application', ['uses' => 'ApplicationController@index_project']);
        Route::get('project/{project}/assets', ['uses' => 'AssetsController@index']);
        Route::get('project/{project}/messenger', ['uses' => 'MessengerController@index']);
        //TODO ar trebui schimbat application/user in user/application dar ii conflict cu user/{?username}
        Route::get('application/user', ['uses' => 'ApplicationController@index_user']);
        Route::get('project/{project}/assets/download', ['as' => 'download_all_assets', 'uses' => 'AssetsController@download_all']);
        Route::get('assets/{assets}/download', ['as' => 'download_asset', 'uses' => 'AssetsController@download']);

        Route::post('messenger', ['uses' => 'MessengerController@store']);
        Route::post('project', ['uses' => 'ProjectController@store']);
        Route::post('project/{project}/favorite', ['uses' => 'ProjectController@favorite']);
        Route::put('project/{project}', ['uses' => 'ProjectController@update']);
        Route::delete('project/{project}', ['uses' => 'ProjectController@destroy']);

        Route::post('position', ['uses' => 'PositionController@store']);
        Route::put('position/{position}', ['uses' => 'PositionController@update']);
        Route::delete('position/{position}', ['uses' => 'PositionController@destroy']);

        Route::post('comment', ['uses' => 'CommentController@store']);
        Route::delete('comment/{comment}', ['uses' => 'CommentController@destroy']);

        Route::post('application', ['uses' => 'ApplicationController@store']);
        Route::put('application/{application}', ['uses' => 'ApplicationController@update']);
        Route::delete('application/{application}', ['uses' => 'ApplicationController@destroy']);

        Route::put('user', ['uses' => 'UserController@update']);
        Route::put('user/skill', ['uses' => 'UserController@update_skill']);

        Route::post('assets', ['uses' => 'AssetsController@store']);
        Route::delete('assets/{assets}', ['uses' => 'AssetsController@destroy']);
    });
});