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
        return view('welcome');
    });

    Route::post('oauth/access_token', function() {

       return Response::json(Authorizer::issueAccessToken());

    });

    Route::group(['middleware'=>'oauth'], function(){

        Route::resource('client','ClientController', ['except' => ['create','edit']]);

        Route::get('project/{id}/note','ProjectNoteController@index');
        Route::post('project/{id}/note','ProjectNoteController@store');
        Route::get('project/{id}/note/{noteId}','ProjectNoteController@show');
        Route::put('project/note/{id}','ProjectNoteController@update');
        Route::delete('project/note/{id}','ProjectNoteController@destroy');

        //route::group(['middleware'=>'CheckProjectOwner'], function(){

            Route::resource('project','ProjectController', ['except' => ['create','edit']]);

       // });

    });

});
