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

Route::get('/', function () {
    return view('welcome');
});

// plant routes

// post
Route::post('/plants', 'PlantController@store')->middleware('auth');
//get
Route::get('/plants', 'PlantController@index');
Route::get('/plants/create', 'PlantController@create')->middleware('auth');
Route::get('/plants/{id}', 'PlantController@show');
// delete
Route::delete('/plants/{id}', 'PlantController@destroy')->middleware('auth');

//plant submissions (posts) routes

//post
Route::post('/submissions', 'PlantSubmissionController@store')->middleware('auth');
// get
Route::get('/submissions', 'PlantSubmissionController@index');
Route::get('/submissions/create', 'PlantSubmissionController@create')->middleware('auth');
Route::get('/submissions/{id}', 'PlantSubmissionController@show');
// delete
Route::delete('/submissions/{id}', 'PlantSubmissionController@destroy')->middleware('auth');

// auth rotes
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
