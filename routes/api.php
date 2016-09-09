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

Route::group(['prefix' => 'v1', 'middleware' => ['api']], function () {

    Route::get('project', ['uses' => 'ProjectController@index'])->middleware(['jwt.optional']);
    Route::get('project/{project}/comment', ['uses' => 'CommentController@index']);
    Route::get('skill', ['uses' => 'SkillController@index']);
    Route::get('user/{user?}', ['uses' => 'UserController@index'])->middleware(['jwt.optional']);

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('project/{project}/messenger', ['uses' => 'MessengerController@index']);
        Route::post('messenger', ['uses' => 'MessengerController@store']);

        Route::get('notification/count', ['uses' => 'NotificationController@notification_count']);
        Route::get('notification', ['uses' => 'NotificationController@index']);

        Route::post('project', ['uses' => 'ProjectController@store']);
        Route::post('project/{project}/favorite', ['uses' => 'ProjectController@favorite']);
        Route::put('project/{project}', ['uses' => 'ProjectController@update']);
        Route::delete('project/{project}', ['uses' => 'ProjectController@destroy']);

        Route::post('position', ['uses' => 'PositionController@store']);
        Route::put('position/{position}', ['uses' => 'PositionController@update']);
        Route::delete('position/{position}', ['uses' => 'PositionController@destroy']);

        Route::post('comment', ['uses' => 'CommentController@store']);
        Route::delete('comment/{comment}', ['uses' => 'CommentController@destroy']);

        Route::get('position/{position}/application', ['uses' => 'ApplicationController@index_position']);
        //TODO ar trebui schimbat application/user in user/application dar ii conflict cu user/{?username}
        Route::get('application/user', ['uses' => 'ApplicationController@index_user']);
        Route::post('application', ['uses' => 'ApplicationController@store']);
        Route::put('application/{application}', ['uses' => 'ApplicationController@update']);
        Route::delete('application/{application}', ['uses' => 'ApplicationController@destroy']);

        Route::put('user', ['uses' => 'UserController@update']);
    });
});

