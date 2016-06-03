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

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('app');
    });

    Route::post('oauth/access_token', function() {

       return Response::json(Authorizer::issueAccessToken());

    });

    Route::group(['middleware'=>'oauth'], function(){

        Route::resource('client','ClientController', ['except' => ['create','edit']]);

        Route::resource('project','ProjectController', ['except' => ['create','edit']]);

        Route::resource('project.member','ProjectMemberController', ['except' => ['create','edit','update']]);

        Route::group(['middleware' => 'check-project-permission','prefix' => 'project'], function(){

            Route::get('{id}/note','ProjectNoteController@index');
            Route::post('{id}/note','ProjectNoteController@store');
            Route::get('{id}/note/{idNote}','ProjectNoteController@show');
            Route::put('{id}/note/{idNote}','ProjectNoteController@update');
            Route::delete('{id}/note/{idNote}','ProjectNoteController@destroy');

            Route::get('{id}/task','ProjectTaskController@index');
            Route::post('{id}/task','ProjectTaskController@store');
            Route::put('{id}/task/{idTask}','ProjectTaskController@update');
            Route::get('{id}/task/{idTask}','ProjectTaskController@show');
            Route::delete('{id}/task/{idTask}','ProjectTaskController@destroy');

            Route::get('{id}/file','ProjectFileController@index');
            Route::get('{id}/file/{idFile}/download','ProjectFileController@downloadFile');
            Route::post('{id}/file','ProjectFileController@store');
            Route::get('{id}/file/{idFile}','ProjectFileController@show');
            Route::put('{id}/file/{idFile}','ProjectFileController@update');
            Route::delete('{id}/file/{idFile}','ProjectFileController@destroy');

        });

        Route::get('user/authenticated','UserController@authenticated');
        Route::resource('user','UserController', ['except' => ['create','edit']]);

    });

});
