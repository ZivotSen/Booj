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

Route::match(['get'], '/', array(
    'before' => 'csrf',
    'as' => 'index',
    'uses' => '\App\Http\Controllers\BookController@index'
));
Route::match(['get', 'post'], '/create', array(
    'before' => 'csrf',
    'as' => 'create',
    'uses' => '\App\Http\Controllers\BookController@store'
));
Route::match(['get'], '/view/{id}/', array(
    'before' => 'csrf',
    'as' => 'view',
    'uses' => '\App\Http\Controllers\BookController@show'
));
Route::match(['get', 'put'], '/edit/{id}/', array(
    'before' => 'csrf',
    'as' => 'update',
    'uses' => '\App\Http\Controllers\BookController@edit'
));
Route::match(['delete'], '/delete/{id}/', array(
    'before' => 'csrf',
    'as' => 'delete',
    'uses' => '\App\Http\Controllers\BookController@destroy'
));
