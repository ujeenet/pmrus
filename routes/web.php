<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();


Route::get('/projects' );
Route::get('/resources' );

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'profile','middleware'=>'auth'], function(){
        Route::get('/', 'ProfileController@index');
        Route::post('/update/{id}', 'ProfileController@update');
});

Route::group(['prefix'=>'project','middleware'=>'auth'],
    function(){
        Route::get('/index/{parameter?}','ProjectController@index');
        Route::get('/listall/{parameter?}','ProjectController@listall');
        Route::post('/create','ProjectController@create');
        Route::get('/edit','ProjectController@edit');
        Route::post('/update/{id}','ProjectController@update');
        Route::delete('/delete/{id}','ProjectController@destroy');
        Route::get('/discard/{id}','ProjectController@discard');
});

Route::group(['prefix'=>'checkpoint','middleware'=>'auth'],
    function(){
        Route::get('/index/{parameter?}','CheckpointController@index');
        Route::get('/listall/{parameter?}','CheckpointController@listall');
        Route::post('/create','CheckpointController@create');
        Route::get('/estimate/{pid}','CheckpointController@estimate');
        Route::post('/update','CheckpointController@update');
        Route::delete('/delete/{id}','CheckpointController@destroy');
});

Route::group(['prefix'=>'resource','middleware'=>'auth'],
    function(){
        Route::get('/index','ResourceController@index');
        Route::get('/getname/{id}','ResourceController@getname');
        Route::get('/listall/{parameter?}','ResourceController@listall');
        Route::post('/create/{request?}','ResourceController@create');
        Route::get('/edit/{id}','ResourceController@edit');
        Route::post('/update/{id}','ResourceController@update');
        Route::delete('/delete/{id}','ResourceController@destroy');
    });