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

/*
|--------------------------------------------------------------------------
| Login Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'auth/login', 'name' => 'auth.login.'], function () {
    Route::get('/', 'LoginController@index')->name('index');
    Route::post('/', 'LoginController@login')->name('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => '/', 'name' => 'dashboard.'], function () {
    Route::get('/', 'PurchaseController@index')->name('purchase.index');

    Route::group(['prefix' => '/buyers', 'name' => 'buyer.'], function () {
        Route::get('/', 'BuyerController@index')->name('index');
        Route::get('/{user}', 'BuyerController@show')->name('show');
    });
});
