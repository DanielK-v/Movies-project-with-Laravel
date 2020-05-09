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

Route::resource('movie', 'MoviesController');
Route::resource('comment', 'CommentController');

// Route::get('movie','MoviesController@index');
// Route::get('movie/{movie}','MoviesController@show');
// Route::get('movie/create','MoviesController@create');
// Route::post('movies/store','MoviesController@store')->name('movie-store');
// Route::delete('movies','MoviesController@destroy')->name('movie-destroy');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
