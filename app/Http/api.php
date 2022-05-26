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

// Xử lý người dùng đã đăng nhập
    Route::post('/signup', 'AuthController@signup');
    Route::post('/login', 'AuthController@login')->name('api.login');

// Route::group(function () {
    // Customer
    Route::get('/customer', 'Api\CustomerController@index')->middleware('jwt.verify');
    Route::post('/customer', 'Api\CustomerController@store');
    Route::get('/customer/{id}', 'Api\CustomerController@show');
    Route::post('/customer/{id}', 'Api\CustomerController@update');
    Route::delete('/customer/{id}', 'Api\CustomerController@destroy');

// });


    Route::post('/authenticate', 'Api\AuthController@login')->name('api.authenticate')->middleware('guest');
    
    Route::get('/me', 'Api\AuthController@me');

