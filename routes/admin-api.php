<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => '/' ], function () {
    Route::get('purchase/list', 'PurchaseController@list')->name('purchase.list');
    Route::get('buyers/list', 'BuyerController@list')->name('buyer.list');
});
