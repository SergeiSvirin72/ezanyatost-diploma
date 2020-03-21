<?php

use Illuminate\Support\Facades\Route;

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

// AUTH
Auth::routes(['register' => false]);

// OPENED
Route::get('/', function () {
    return view('opened.index');
});

// CLOSED
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function() {
    // REPORTS
    Route::group(['prefix' => 'report'], function() {
        Route::get('class', function () {return true;})->middleware('check.role:1,2');
        Route::get('status', function () {return true;});
        Route::get('student', function () {return true;});
        Route::get('course', function () {return true;});
        Route::get('events', function () {return true;});
        Route::get('attendance', function () {return true;});
        Route::get('homework', function () {return true;});
    });

    // ADMIN
    Route::group(['prefix' => 'admin'], function() {
        // Organisations
        Route::get('organisations',
            'OrganisationController@index');
        Route::get('organisations/create',
            'OrganisationController@create');
        Route::post('organisations',
            'OrganisationController@store');
        Route::get('organisations/{organisation}',
            'OrganisationController@show');
        Route::get('organisations/{organisation}/edit',
            'OrganisationController@edit');
        Route::patch('organisations/{organisation}',
            'OrganisationController@update');
        Route::delete('organisations/{organisation}',
            'OrganisationController@destroy');
        Route::get('organisations/{organisation}/delete_image',
            'OrganisationController@delete_image');

        // Associations
        Route::get('associations',
            'AssociationController@index');
        Route::get('associations/create',
            'AssociationController@create');
        Route::post('associations',
            'AssociationController@store');
        Route::delete('associations/{association}',
            'AssociationController@destroy');

        // Activities
        Route::get('activities',
            'ActivityController@index');
        Route::get('activities/create',
            'ActivityController@create');
        Route::post('activities',
            'ActivityController@store');
        Route::delete('activities/{activity}',
            'ActivityController@destroy');

        // Users
        Route::get('users',
            'UserController@index');
        Route::get('users/create',
            'UserController@create');
        Route::post('users',
            'UserController@store');
        Route::delete('users/{user}',
            'UserController@destroy');

        // Employment
        Route::get('employments',
            'EmploymentController@index');
        Route::get('employments/create',
            'EmploymentController@create');
        Route::post('employments',
            'EmploymentController@store');
        Route::delete('employments/{employment}',
            'EmploymentController@destroy');
        Route::post('/employments/fetch-associations',
            'EmploymentController@fetchAssociations');

        // Schedules
        Route::get('schedules',
            'ScheduleController@index');
        Route::get('schedules/create',
            'ScheduleController@create');
        Route::post('schedules',
            'ScheduleController@store');
        Route::delete('schedules/{schedule}',
            'ScheduleController@destroy');
    });
});
