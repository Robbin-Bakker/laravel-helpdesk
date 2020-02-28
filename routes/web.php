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

Route::get('/dit/is/een/test', function () {
    return view('test')->with('variabele', config('database.default'));
});

Route::get('/param/{id}', function($id){
    return view('testparameter')->with('id', $id);
})->where('id', '[1-9][0-9]*');

Route::get('/hi/{id}', 'TestController@hi')
->where('id', '[1-9][0-9]*');

Route::get('/random/min={min}&max={max}', 'TestController@random')
->where(['min' => '[0-9]*', 'max' => '[0-9]*']);

Route::get('/generation/{age}', 'TestController@generation')
->where('age', '[1-9][0-9]?');