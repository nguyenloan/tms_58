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
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'UserController');
    Route::get('/courses/{id}/trainees', ['as' => 'courses.trainees', 'uses' => 'Trainee\CourseController@trainees']);
    Route::get('/courses/{id}/enroll', ['as' => 'courses.enroll', 'uses' => 'Trainee\CourseController@enroll']);
    Route::get('calendar', ['as' => 'calendar', 'uses' => 'UserController@calendarUser']);
    Route::put('task/ajax-update', ['as' => 'tasks.ajax-update', 'uses' => 'Trainee\TaskController@ajaxUpdate']);
    Route::get('task/{id}', ['as' => 'task', 'uses' => 'Trainee\SubjectController@subjectTask']);
    Route::resource('courses', 'Trainee\CourseController');
    Route::resource('subjects', 'Trainee\SubjectController');
    Route::resource('tasks', 'Trainee\TaskController');
    Route::resource('reports', 'Trainee\ReportController');
    Route::get('courses/{id}/getFinishCourse', [
        'as' => 'admin.courses.getFinishCourse',
        'uses' => 'Suppervisor\CourseController@getFinishCourse'
    ]);
    Route::put('courses/putFinishCourse/{id}', [
        'as' => 'admin.courses.putFinishCourse',
        'uses' => 'Suppervisor\CourseController@putFinishCourse'
    ]);
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('subjects', 'Suppervisor\SubjectController');
        Route::get('courses/addSuppervisor/{id}', 'Suppervisor\CourseController@addSuppervisor');
        Route::post('courses/addSuppervisor', [
            'as' => 'addSuppervisor',
            'uses' => 'Suppervisor\CourseController@createSupper'
        ]);
        Route::get('/courses/{id}/trainee-progress', ['as' => 'admin.courses.trainee-progress', 'uses' => 'Suppervisor\CourseController@traineeProgress']);
        Route::resource('courses', 'Suppervisor\CourseController');
        Route::resource('tasks', 'Suppervisor\TaskController');
        Route::resource('userCourses', 'Suppervisor\UserCourseController');
        Route::resource('trainees', 'Suppervisor\TraineeController');
        Route::get('subjects/{id}/editTask', 'Suppervisor\SubjectController@editTask');
    });
});

Route::group(['middleware' => 'web'], function() {
    Route::post('login', ['as' => 'login', 'uses' => 'UserController@login']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
    Route::post('register', ['as' => 'register', 'uses' => 'UserController@register']);
});
