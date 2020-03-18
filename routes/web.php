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

        // Association - Organisation
        Route::get('association-organisation',
            'AssociationOrganisationController@index');
        Route::get('association-organisation/create',
            'AssociationOrganisationController@create');
        Route::post('association-organisation',
            'AssociationOrganisationController@store');
        Route::delete('association-organisation/{id}',
            'AssociationOrganisationController@destroy');
    });
});
