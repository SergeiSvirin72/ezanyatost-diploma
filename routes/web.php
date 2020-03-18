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
        Route::resource('organisations', 'OrganisationController');
        Route::get('organisations/{organisation}/delete_image', 'OrganisationController@delete_image');
    });
});
// Reports


