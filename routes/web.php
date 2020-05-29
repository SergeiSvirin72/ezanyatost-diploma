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
Route::get('/', 'OpenedController@index');
Route::get('/contacts', 'OpenedController@contactIndex');
Route::post('/contacts', 'OpenedController@contactSend');

// Organisations
Route::group(['prefix' => 'organisations'], function() {
    Route::get('/', 'OpenedController@organisationIndex');
    Route::get('/{organisation}', 'OpenedController@organisationShow');
    Route::post('/schedule', 'OpenedController@scheduleFetch');
});

// Events
Route::group(['prefix' => 'events'], function() {
    Route::get('/', 'OpenedController@eventIndex');
    Route::get('/{event}', 'OpenedController@eventShow');
    Route::post('/fetch', 'OpenedController@eventFetch');
});

// CLOSED
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home/email', 'HomeController@email');
Route::post('/home/password', 'HomeController@password');

Route::group(['middleware' => 'auth'], function() {
    // REPORTS
    Route::group(['prefix' => 'report'], function() {
        // Class
        Route::group(['prefix' => 'class', 'middleware' => ['check.role:1,2', 'has.organisation']], function() {
            Route::get('/', 'ReportController@class');
            Route::post('/fetch', 'ReportController@classFetch');
            Route::post('/export', 'ReportController@classExport');
        });

        // Status
        Route::group(['prefix' => 'status', 'middleware' => ['check.role:1,2', 'has.organisation']], function() {
            Route::get('/','ReportController@status');
            Route::post('/fetch', 'ReportController@statusFetch');
            Route::post('/export', 'ReportController@statusExport');
        });

        // Student
        Route::group(['prefix' => 'student', 'middleware' => ['check.role:1,2', 'has.organisation', 'is.school']], function() {
            Route::get('/', 'ReportController@student');
            Route::post('/fetch', 'ReportController@studentFetch');
            Route::post('/export', 'ReportController@studentExport');
        });

        // Course
        Route::group(['prefix' => 'course', 'middleware' => ['check.role:1,2', 'has.organisation']], function() {
            Route::get('/', 'ReportController@course');
            Route::post('/fetch', 'ReportController@courseFetch');
            Route::post('/export', 'ReportController@courseExport');
        });

        // Attendance
        Route::group(['prefix' => 'attendance', 'middleware' => ['check.role:1,2', 'has.organisation', 'is.school']], function() {
            Route::get('/', 'ReportController@attendance');
            Route::post('/fetch', 'ReportController@attendanceFetch');
            Route::post('/export', 'ReportController@attendanceExport');
        });

        // Event
        Route::group(['prefix' => 'event', 'middleware' => ['check.role:1,2,5']], function() {
            Route::get('/', 'ReportController@event');
            Route::post('/fetch', 'ReportController@eventFetch');
        });

        // Homework
        Route::group(['prefix' => 'homework', 'middleware' => 'check.role:5'], function() {
            Route::get('/student', 'ReportController@homeworkStudent');
            Route::post('/student/fetch', 'ReportController@homeworkStudentFetch');
            Route::get('/student/{homework}', 'ReportController@homeworkStudentShow');
        });

        // Involvement
        Route::group(['prefix' => 'involvement', 'middleware' => 'check.role:5'], function() {
            Route::get('/', 'ReportController@involvement');
            Route::get('/create', 'ReportController@involvementCreate');
            Route::post('/store', 'ReportController@involvementStore');
        });

        // Visit
        Route::group(['prefix' => 'visit', 'middleware' => 'check.role:5'], function() {
            Route::get('/', 'ReportController@visit');
            Route::post('/fetch', 'ReportController@visitFetch');
        });

        Route::post('/fetch-classes', 'ReportController@fetchClasses');
        Route::post('/fetch-letters', 'ReportController@fetchLetters');
        Route::post('/fetch-students', 'ReportController@fetchStudents');
        Route::post('/fetch-courses', 'ReportController@fetchCourses');
    });

    // ADMIN
    Route::group(['prefix' => 'admin'], function() {
        // Users
        Route::group(['prefix' => 'users', 'middleware' => 'check.role:1'], function() {
            Route::get('/', 'UserController@index');
            Route::post('/fetch', 'UserController@fetchData');
            Route::get('/create', 'UserController@create');
            Route::post('/', 'UserController@store');
            Route::delete('/{user}', 'UserController@destroy');
            Route::post('/import', 'UserController@import');
            Route::get('/export', 'UserController@export');
        });

        // Organisations
        Route::group(['prefix' => 'organisations', 'middleware' => 'check.role:1'], function() {
            Route::get('/', 'OrganisationController@index');
            Route::post('/fetch', 'OrganisationController@fetchData');
            Route::get('/create', 'OrganisationController@create');
            Route::post('/', 'OrganisationController@store');
            Route::get('/{organisation}','OrganisationController@show');
            Route::get('/{organisation}/edit', 'OrganisationController@edit');
            Route::patch('/{organisation}', 'OrganisationController@update');
            Route::delete('/{organisation}', 'OrganisationController@destroy');
            Route::get('/{organisation}/delete_image', 'OrganisationController@delete_image');
        });

        // Associations
        Route::group(['prefix' => 'associations', 'middleware' => ['check.role:1,2', 'has.organisation']], function() {
            Route::get('/', 'AssociationController@index');
            Route::post('/fetch', 'AssociationController@fetchData');
            Route::get('/create', 'AssociationController@create');
            Route::post('/', 'AssociationController@store');
            Route::delete('/{association}', 'AssociationController@destroy');
        });

        // Teachers
        Route::group(['prefix' => 'teachers', 'middleware' => ['check.role:1,2', 'has.organisation']], function() {
            Route::get('/', 'TeacherController@index');
            Route::post('/fetch', 'TeacherController@fetchData');
            Route::get('/create', 'TeacherController@create');
            Route::post('/', 'TeacherController@store');
            Route::delete('/{teacher}', 'TeacherController@destroy');
            Route::post('/fetch-associations', 'TeacherController@fetchAssociations');
            Route::post('/import', 'TeacherController@import');
        });

        // Schedules
        Route::group(['prefix' => 'schedules', 'middleware' => ['check.role:1,2', 'has.organisation']], function() {
            Route::get('/', 'ScheduleController@index');
            Route::post('/fetch', 'ScheduleController@fetchData');
            Route::get('/create', 'ScheduleController@create');
            Route::post('/', 'ScheduleController@store');
            Route::delete('/{schedule}', 'ScheduleController@destroy');
            Route::post('/fetch-associations', 'ScheduleController@fetchAssociations');
            Route::post('/fetch-teachers', 'ScheduleController@fetchTeachers');
            Route::post('/import', 'ScheduleController@import');
        });

        // Students
        Route::group(['prefix' => 'students', 'middleware' => ['check.role:1,2', 'has.organisation', 'is.school']], function() {
            Route::get('/', 'StudentController@index');
            Route::post('/fetch', 'StudentController@fetchData');
            Route::get('/create', 'StudentController@create');
            Route::post('/', 'StudentController@store');
            Route::delete('/{student}', 'StudentController@destroy');
            Route::post('/import', 'StudentController@import');
        });

        // Statuses
        Route::group(['prefix' => 'statuses', 'middleware' => ['check.role:1,2', 'has.organisation', 'is.school']], function() {
            Route::get('/', 'StatusController@index');
            Route::post('/fetch', 'StatusController@fetchData');
            Route::get('/create', 'StatusController@create');
            Route::post('/', 'StatusController@store');
            Route::delete('/{student}', 'StatusController@destroy');
            Route::post('/fetch-classes', 'StatusController@fetchClasses');
            Route::post('/fetch-letters', 'StatusController@fetchLetters');
            Route::post('/fetch-students', 'StatusController@fetchStudents');
            Route::post('/import', 'StatusController@import');
        });

        // Involvements
        Route::group(['prefix' => 'involvements', 'middleware' => ['check.role:1,2', 'has.organisation']], function() {
            Route::get('/', 'InvolvementController@index');
            Route::post('/fetch', 'InvolvementController@fetchData');
            Route::get('/create', 'InvolvementController@create');
            Route::post('/', 'InvolvementController@store');
            Route::delete('/{involvement}', 'InvolvementController@destroy');
            Route::post('/fetch-classes', 'InvolvementController@fetchClasses');
            Route::post('/fetch-letters', 'InvolvementController@fetchLetters');
            Route::post('/fetch-students', 'InvolvementController@fetchStudents');
            Route::post('/fetch-associations', 'InvolvementController@fetchAssociations');
            Route::post('/import', 'InvolvementController@import');
        });

        // Homeworks
        Route::group(['prefix' => 'homeworks', 'middleware' => ['check.role:1,2,3', 'has.organisation', 'has.association']], function() {
            Route::get('/', 'HomeworkController@index');
            Route::post('/fetch', 'HomeworkController@fetchData');
            Route::get('/create', 'HomeworkController@create');
            Route::post('/', 'HomeworkController@store');
            Route::get('/{homework}', 'HomeworkController@show');
            Route::delete('/{homework}', 'HomeworkController@destroy');
            Route::post('/fetch-associations', 'HomeworkController@fetchAssociations');
        });

        // Attendances
        Route::group(['prefix' => 'attendances', 'middleware' => ['check.role:1,2,3', 'has.organisation', 'has.association']], function() {
            Route::get('/', 'AttendanceController@index');
            Route::post('/fetch', 'AttendanceController@fetchData');
            Route::post('/edit', 'AttendanceController@edit');
            //Route::post('/fetch-associations', 'AttendanceController@fetchAssociations');
        });
        Route::post('/fetch-associations', 'AttendanceController@fetchAssociations')->middleware(['check.role:1,2,3', 'has.organisation', 'has.association']);

        // Events
        Route::group(['prefix' => 'events', 'middleware' => ['check.role:1,2', 'has.organisation']], function() {
            Route::get('/', 'EventController@index');
            Route::post('/fetch', 'EventController@fetchData');
            Route::get('/create', 'EventController@create');
            Route::post('/', 'EventController@store');
            Route::get('/{event}', 'EventController@show');
            Route::delete('/{event}', 'EventController@destroy');
        });
    });
});
