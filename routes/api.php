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

Route::namespace('Api')->middleware('cors')->group(function () {

    Route::post('/users','UserController@store')->name('users.store');
    Route::post('/login','UserController@login')->name('users.login');
    Route::get('/users','UserController@index')->name('users.index');
    Route::get('/users/{user}','UserController@show')->name('users.show');


    Route::middleware('api.refresh')->group(function () {
        Route::get('/users/info','UserController@info')->name('users.info');
    });
});
