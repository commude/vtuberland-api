<?php

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
});

/*
|--------------------------------------------------------------------------
| Me Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'me'], function () {
    Route::post('/', 'MeController@register');
    Route::post('/update', 'MeController@update')->middleware('auth:user');
    Route::post('refresh', 'AuthController@refresh');
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
| Spot Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'spots'], function () {
    Route::get('/', 'SpotController@index');  // Home screen
    Route::get('/{spot}', 'SpotController@show'); // View spot screen

    Route::group(['prefix' => '{spot}/characters'], function () {
        Route::get('/', 'SpotController@characters');  // Spot character list
        Route::get('/{character}', 'SpotController@showCharacter'); // View archive Character screen
        Route::post('/{character}/purchase', 'SpotController@purchase')->middleware('auth:user');  // Purchase Character
    });
});

/*
|--------------------------------------------------------------------------
| Archive Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'characters'], function () {
    Route::get('/', 'ArchiveController@index');  // Archive screen
    Route::get('/{spot_character}', 'ArchiveController@show');  // View character screen
});

/*
|--------------------------------------------------------------------------
| Purchase Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'purchases', 'middleware' => 'auth:user'], function () {
    Route::get('/', 'PurchaseController@index')->middleware(['paginated']);  // Get the list of Purchases
    Route::get('/{user_spot_character}', 'PurchaseController@show');  // View Purchase screen
});

