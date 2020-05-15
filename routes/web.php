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
    return view('welcome');
});

Route::get('/index', 'TestController@index')->name('tickets');
Route::get('/ticket/{id}', 'TestController@ticket')->name('ticket');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
