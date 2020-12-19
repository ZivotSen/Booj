<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Internal Routes
Route::match(['get', 'post'], '/book/list/', array(
    'before' => 'csrf',
    'as' => 'api_book_list',
    'uses' => '\App\Http\Controllers\BookController@listFromAPI'
))->middleware('api');
Route::match(['post'], '/book/create/', array(
    'before' => 'csrf',
    'as' => 'api_book_create',
    'uses' => '\App\Http\Controllers\BookController@storeFromAPI'
));
Route::match(['get'], '/book/view/', array(
    'before' => 'csrf',
    'as' => 'api_book_view',
    'uses' => '\App\Http\Controllers\BookController@showFromAPI'
))->middleware('api');
Route::match(['put'], '/book/edit/', array(
    'before' => 'csrf',
    'as' => 'api_book_update',
    'uses' => '\App\Http\Controllers\BookController@editFromAPI'
))->middleware('api');
Route::match(['delete'], '/book/delete/', array(
    'before' => 'csrf',
    'as' => 'api_book_delete',
    'uses' => '\App\Http\Controllers\BookController@destroyFromAPI'
))->middleware('api');

// Endpoint for openlibrary.org integration
Route::prefix('/book/library')->group(function() {
    /*
     * Available routes to get a book
     * */
    Route::get('/', array(
        'as' => 'api_book_library',
        'uses' => '\App\Http\Controllers\LibraryController@library'
    ))->middleware('api');
});
