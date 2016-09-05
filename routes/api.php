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

    Route::get('project', ['uses' => 'ProjectController@index']);
    Route::get('skill', ['uses' => 'SkillController@index']);
    Route::get('user/{username?}', ['uses' => 'UserController@index']);

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('project', ['uses' => 'ProjectController@store']);
        Route::put('project/{project}', ['uses' => 'ProjectController@update']);
        Route::delete('project/{project}', ['uses' => 'ProjectController@destroy']);

        //Route::get('application', ['uses' => 'ApplicationController@index']);
        Route::post('application', ['uses' => 'ApplicationController@store']);
        Route::delete('application/{application}', ['uses' => 'ApplicationController@destroy']);

        Route::post('skill', ['uses' => 'SkillController@store']);

        Route::post('comment', ['uses' => 'CommentController@store']);
        Route::delete('comment/{comment}', ['uses' => 'CommentController@destroy']);

        Route::put('user', ['uses' => 'UserController@update']);
    });
});

