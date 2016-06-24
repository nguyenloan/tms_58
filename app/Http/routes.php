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

// Authentication routes...
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);
    // Registration routes...
    Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@getRegister']);
    Route::post('register', 'Auth\AuthController@postRegister');
});
Route::group(['prefix' => 'password'], function () {
    Route::get('email', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@getEmail']);
    Route::post('email', ['uses' => 'Auth\PasswordController@postEmail']);
    // Password reset routes...
    Route::get('reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@getReset']);
    Route::post('reset', 'Auth\PasswordController@postReset');
});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'UserController');
});
