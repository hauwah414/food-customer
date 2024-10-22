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

Route::middleware([AuthPassport::class])->prefix('address')->group(function () {
    Route::get('/', 'AddressController@index');
    Route::get('/create', 'AddressController@create')->name('create');

    Route::get('/show/{id}', 'AddressController@show')->name('show');
    Route::get('/update/{id}', 'AddressController@update')->name('update');

    Route::DELETE('/destroy', 'AddressController@destroy')->name('destroy');
    Route::post('/ajaxCities', 'AddressController@ajaxCities')->name('ajaxCities');
    Route::post('/ajaxDistricts', 'AddressController@ajaxDistricts')->name('ajaxDistricts');
    Route::post('/ajaxSubDistric', 'AddressController@ajaxSubDistric')->name('ajaxSubDistric');
    Route::post('/store', 'AddressController@store')->name('store');
    Route::post('/mainAddress', 'AddressController@mainAddress')->name('mainAddress');
});
