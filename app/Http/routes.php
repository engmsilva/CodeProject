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

        Route::get('project/{id}/note','ProjectNoteController@index');
        Route::post('project/{id}/note','ProjectNoteController@store');
        Route::get('project/{id}/note/{idNote}','ProjectNoteController@show');
        Route::put('project/{id}/note/{idNote}','ProjectNoteController@update');
        Route::delete('project/{id}/note/{idNote}','ProjectNoteController@destroy');

        Route::get('project/{id}/members','ProjectController@members');
        Route::post('project/{id}/member/{idUser}','ProjectController@addMember');
        Route::delete('project/{id}/member/{idUser}','ProjectController@removeMember');

        Route::get('project/{id}/task','ProjectTaskController@index');
        Route::post('project/{id}/task','ProjectTaskController@store');
        Route::put('project/{id}/task/{idTask}','ProjectTaskController@update');
        Route::get('project/{id}/task/{idTask}','ProjectTaskController@show');
        Route::delete('project/{id}/task/{idTask}','ProjectTaskController@destroy');

        Route::post('project/{id}/file','ProjectFileController@store');
        Route::delete('project/{id}/file/{idFile}','ProjectFileController@destroy');

        Route::get('user/authenticated','UserController@authenticated');

        //route::group(['middleware'=>'CheckProjectOwner'], function(){

        Route::resource('project','ProjectController', ['except' => ['create','edit']]);

       // });

    });

});
