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

Route::middleware([AuthPassport::class])->prefix('billpayment')->group(function () {
    Route::get('/', 'BillpaymentController@index');
    Route::get('/waiting', 'BillpaymentController@waiting')->name('billpayment-waiting');
    Route::get('/done', 'BillpaymentController@done')->name('billpayment-done');
    Route::get('/order', 'BillpaymentController@order')->name('billpayment-order');
    Route::get('/order/detail/{slug}', 'BillpaymentController@orderDetail')->name('billpayment-detail');
    Route::get('/detail/{slug}', 'BillpaymentController@show')->name('billpayment-show');
    Route::post('/check', 'BillpaymentController@check')->name('billpayment-check');
    Route::post('/confirm', 'BillpaymentController@confirm')->name('billpayment-confirm');
    Route::post('/count', 'BillpaymentController@count')->name('billpayment-count');
    Route::post('/filter', 'BillpaymentController@filter')->name('billpayment-filter');
});
