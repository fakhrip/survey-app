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
    return view('guest');
})->name('app');

Auth::routes(['register' => false]);

Route::get('/admin', 'HomeController@index')->name('admin');

Route::get('{path}', function () {
    return view('/layouts/master');
})->where( 'path', '([A-z\d-\/_.]+)?' );
