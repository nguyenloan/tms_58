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
    Route::get('/courses/{id}/trainees', ['as' => 'courses.trainees', 'uses' => 'Trainee\CourseController@trainees']);
    Route::get('/courses/{id}/enroll', ['as' => 'courses.enroll', 'uses' => 'Trainee\CourseController@enroll']);
    Route::resource('courses', 'Trainee\CourseController');
    Route::resource('subjects', 'Trainee\SubjectController');
    Route::resource('tasks', 'Trainee\TaskController');
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('subjects', 'Suppervisor\SubjectController');
        Route::get('courses/addSuppervisor/{id}', 'Suppervisor\CourseController@addSuppervisor');
        Route::post('courses/addSuppervisor', [
            'as' => 'addSuppervisor',
            'uses' => 'Suppervisor\CourseController@createSupper'
        ]);
        Route::resource('courses', 'Suppervisor\CourseController');
        Route::resource('tasks', 'Suppervisor\TaskController');
        Route::resource('userCourses', 'Suppervisor\UserCourseController');
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

