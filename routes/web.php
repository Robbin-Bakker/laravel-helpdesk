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

// USER
Auth::routes();
Route::get('/home', 'HomeController@index')
    ->name('home');

// TICKETS
Route::get('/ticket/create', 'TicketController@create')
    ->name('ticket_create');

Route::post('/ticket/save', 'TicketController@save')
    ->name('ticket_save');

Route::get('/ticket/index', 'TicketController@index')
    ->name('ticket_index');

Route::get('/ticket/index_helpdesk', 'TicketController@index_helpdesk')
    ->name('ticket_index_helpdesk');

Route::get('/ticket/{ticket}/show', 'TicketController@show')
    ->name('ticket_show');

Route::put('/ticket/{id}/update', 'TicketController@update')
    ->name('ticket_update');

Route::post('/ticket/{ticket}/comment/save', 'CommentController@save')
    ->name('comment_save');