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

Route::get('/gettasks', 'TasksController@gettasks');
Route::post('/createtask', 'TasksController@createtask');
Route::post('/deletetask', 'TasksController@deletetask');
Route::get('/gettask/{id}', 'TasksController@gettask');
