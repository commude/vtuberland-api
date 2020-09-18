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
Route::group(['middleware' => 'admin.ip'], function () {
    /*
    |--------------------------------------------------------------------------
    | Login Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'auth', 'as' => 'auth.login.'], function () {
        Route::get('/login', 'LoginController@index')->name('index');
        Route::post('/login', 'LoginController@login')->name('post');
    });

    /*
    |--------------------------------------------------------------------------
    | Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => '/', 'as' => 'dashboard.' ,'middleware' => 'auth:admin'], function () {
        Route::post('/logout', 'DashboardController@logout')->name('logout');
        Route::get('/', 'PurchaseController@index')->name('purchase.index');

        Route::group(['prefix' => '/buyers', 'as' => 'buyer.'], function () {
            Route::get('/', 'BuyerController@index')->name('index');
            Route::get('/users/{user}', 'BuyerController@user')->name('user');
        });
    });
});
