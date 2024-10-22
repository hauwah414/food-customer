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



// Route::middleware([AuthPassport::class])->prefix('paylater')->group(function () {
//     Route::get('/', 'PaylaterController@index');
//     Route::get('/waiting', 'PaylaterController@waiting')->name('paylater-waiting');
//     Route::get('/done', 'PaylaterController@done')->name('paylater-done');
//     Route::get('/detail/{slug}', 'PaylaterController@show')->name('paylater-show');
//     Route::post('/check', 'PaylaterController@check')->name('paylater-check');
//     Route::post('/confirm', 'PaylaterController@confirm')->name('paylater-confirm');
//     Route::post('/count', 'PaylaterController@count')->name('paylater-count');
//     Route::post('/filter', 'PaylaterController@filter')->name('paylater-filter');
// });
