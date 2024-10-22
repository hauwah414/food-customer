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

Route::middleware([AuthPassport::class])->prefix('checkout')->group(function () {
    Route::get('/', 'CheckoutController@index'); 
    Route::POST('/newTransaction', 'CheckoutController@newTransaction')->name('newTransaction');
    Route::POST('/confirmation', 'CheckoutController@confirmation')->name('confirmation');
});

Route::middleware([AuthPassport::class])->prefix('checkout/payment')->group(function () {
    Route::POST('/new', 'CheckoutPaymentController@new')->name('new');
    Route::POST('/new/ordernow', 'CheckoutPaymentController@newOrderNow')->name('newOrderNow');
    Route::POST('/confirm', 'CheckoutPaymentController@confirm')->name('confirm');
});

Route::middleware([AuthPassport::class])->prefix('checkout/address')->group(function () {
    Route::POST('/changenow', 'CheckoutAddressController@changeNow')->name('changeNow');
    Route::POST('/change', 'CheckoutAddressController@change')->name('change');
});


Route::middleware([AuthPassport::class])->prefix('checkout/now')->group(function () {
    Route::get('/', 'CheckoutNowController@index');
    Route::POST('/order', 'CheckoutNowController@order')->name('order');
});
