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
Route::group(['prefix' => 'auth', 'name' => 'auth.login.'], function () {
    Route::get('/login', 'LoginController@index')->name('index');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/logout', 'LoginController@logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => '/', 'name' => 'dashboard.' ,'middleware' => 'auth:admin'], function () {
    Route::get('/', 'PurchaseController@index')->name('purchase.index');
    Route::get('/purchaselist', 'PurchaseController@purchaseList')->name('purchase.list');

    Route::group(['prefix' => '/buyers', 'name' => 'buyer.'], function () {
        Route::get('/', 'BuyerController@index')->name('index');
        Route::get('/users/{user}', 'BuyerController@show')->name('users');
        Route::get('/userlist', 'BuyerController@userList')->name('list');
    });
});
