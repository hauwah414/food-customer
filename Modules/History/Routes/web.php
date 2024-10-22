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

Route::middleware([AuthPassport::class])->prefix('history')->group(function () {
    Route::get('/', 'HistoryController@index')->name('history.index');
    Route::POST('/filter', 'HistoryController@filter');

    Route::get('/{slug}', 'HistoryController@show')->name('history.show');
    Route::POST('/payment/confirmation', 'HistoryController@payment');
});
