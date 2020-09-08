<?php

use Illuminate\Http\Request;
use Laravel\Passport\Passport;
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

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('refresh', 'AuthController@refresh');
});

/*
|--------------------------------------------------------------------------
| Me Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'me'], function () {
    Route::post('/', 'MeController@register');
    Route::post('/logout', 'MeController@logout');

    /*
    |--------------------------------------------------------------------------
    | Authenticated Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'auth:user'], function () {
        Route::get('/', 'MeController@index');
    });
});

/*
|--------------------------------------------------------------------------
| Attraction Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'attractions'], function () {
    Route::get('/', 'AttractionController@index');

    Route::group(['middleware' => 'auth:user'], function () {
        // Route::get('/', 'AttractionController@index');
    });
});

/*
|--------------------------------------------------------------------------
| Transaction Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'transactions', 'middleware' => 'auth:user'], function () {
    // Route::post('/', 'TransactionController@index');
});
