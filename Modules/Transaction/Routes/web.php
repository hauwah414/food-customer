<?php

use App\Http\Middleware\AuthPassport;
/*
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

Route::middleware([AuthPassport::class])->prefix('transaction')->group(function () {
    Route::get('/{slug}', 'TransactionController@index');
    Route::post('/cancel', 'TransactionController@destroy')->name('destroy');
    Route::post('/received', 'TransactionController@received')->name('received');
    Route::post('/confirm', 'TransactionController@confirm')->name('confirm');
    Route::post('/check', 'TransactionController@checkTransaction')->name('checkTransaction');
});
