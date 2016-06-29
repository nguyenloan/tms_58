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
Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'UserController');
    Route::resource('courses', 'CourseController');
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('subjects', 'Suppervisor\SubjectController');
        Route::resource('courses', 'Suppervisor\CourseController');
    });
});
Route::auth();
Route::get('home', ['middleware' => 'auth', 'as' => 'home', 'uses' => 'HomeController@index']);
Route::get('authen/getLogin', [
    'as' => 'getLogin',
    'uses' => 'Auth\AuthController@getLogin'
]);
Route::post('authen/login', [
    'as' => 'postLogin',
    'uses' => 'Auth\AuthController@postLogin'
]);


