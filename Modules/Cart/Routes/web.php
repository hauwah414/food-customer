<?php

use App\Http\Middleware\AuthPassport;

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

Route::middleware([AuthPassport::class])->prefix('cart')->group(function () {
    Route::get('/', 'CartController@index')->name('cart');
    Route::POST('/create', 'CartController@create')->name('create');
    Route::POST('/checkbox', 'CartController@checkbox')->name('checkbox');
    Route::POST('/destroy', 'CartController@destroy')->name('destroy');
    Route::POST('/destroy/multiple', 'CartController@destroyMultiple')->name('destroy.multiple');
    Route::POST('/addOrder', 'CartController@addOrder')->name('addOrder');
    Route::POST('/count', 'CartController@count')->name('count');
});
