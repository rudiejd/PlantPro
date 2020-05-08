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

/**************************************************************************
 *                                                                        
 *                                                                        
 *                          PLANT ROUTES                                                
 *                                                                        
 *                                                                 
 *                                                                        
****************************************************************************/

// post
Route::post('/plants', 'PlantController@store')->middleware('auth');
//get
Route::get('/plants', 'PlantController@index');
Route::get('/plants/create', 'PlantController@create')->middleware('auth');
Route::get('/plants/{id}', 'PlantController@show');
// delete
Route::delete('/plants/{id}', 'PlantController@destroy')->middleware('auth');

/**************************************************************************
 *                                                                        
 *                                                                        
 *                          PLANTSUBMISSION ROUTES                                                
 *                                                                        
 *                                                                 
 *                                                                        
****************************************************************************/

//post
Route::post('/submissions', 'PlantSubmissionController@store')->middleware('auth');
Route::post('/submissions/{id}/upvote', 'PlantSubmissionController@upvote')->middleware('auth');
// get
Route::get('/submissions', 'PlantSubmissionController@index');
Route::get('/submissions/create', 'PlantSubmissionController@create')->middleware('auth');
Route::get('/submissions/{id}', 'PlantSubmissionController@show');
// delete
Route::delete('/submissions/{id}', 'PlantSubmissionController@destroy')->middleware('auth');


/**************************************************************************
 *                                                                        
 *                                                                        
 *                          COMMENT ROUTES                                               
 *                                                                        
 *                                                                 
 *                                                                        
****************************************************************************/

// post
Route::post('/comments', 'CommentController@store')->middleware('auth');
Route::post('/comments/{id}/upvote', 'CommentController@upvote')->middleware('auth');

// delete
Route::delete('/comments/{id}', 'CommentController@destroy');


/**************************************************************************
 *                                                                        
 *                                                                        
 *                          SEARCH ROUTES                                                
 *                                                                        
 *                                                                 
 *                                                                        
****************************************************************************/
Route::get('/search', 'SearchController@search');


/**************************************************************************
 *                                                                        
 *                                                                        
 *                          AUTH ROUTES                                                
 *                                                                        
 *                                                                 
 *                                                                        
****************************************************************************/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::post('/makeAdmin', 'HomeController@makeAdmin')->middleware('auth');
Route::post('/makeMod', 'HomeController@makeMod')->middleware('auth');
Route::post('/removeMod', 'HomeController@removeMod')->middleware('auth');
Route::get('/admin', 'HomeController@admin')->middleware('auth');
