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

// TICKET UPDATING
Route::put('/ticket/{ticket}/close', 'TicketController@close')
    ->name('ticket_close');

Route::put('/ticket/{ticket}/claim', 'TicketController@claim')
    ->name('ticket_claim');

Route::put('/ticket/{ticket}/free', 'TicketController@free')
    ->name('ticket_free');

Route::put('/ticket/{ticket}/escalate', 'TicketController@escalate')
    ->name('ticket_escalate');

Route::put('/ticket/{ticket}/deescalate', 'TicketController@deescalate')
    ->name('ticket_deescalate');

Route::put('/ticket/{ticket}/delegate', 'TicketController@delegate')
    ->name('ticket_delegate');

// COMMENTS
Route::post('/ticket/{ticket}/comment/save', 'CommentController@save')
    ->name('comment_save');
