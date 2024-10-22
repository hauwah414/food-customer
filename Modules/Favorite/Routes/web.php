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

Route::middleware([AuthPassport::class])->prefix('favorite')->group(function () {
    Route::get('/', 'FavoriteController@index')->name('favorite');
    Route::get('/page={page}', 'FavoriteController@pagination')->name('favorite-pagination');
    Route::post('/create', 'FavoriteController@create')->name('favorite-create');
    Route::post('/delete', 'FavoriteController@destroy')->name('favorite-destroy');
});
