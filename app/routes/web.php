<?php

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
    return view('home');
})->name('app')->middleware('guest');

Auth::routes();

// To disable registration uncomment this line below and comment line above
// Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
