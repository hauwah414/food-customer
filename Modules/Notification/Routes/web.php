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

Route::middleware([AuthPassport::class])->prefix('notification')->group(function () {
    Route::get('/', 'NotificationController@index');
    Route::get('/page={page}', 'NotificationController@pagination')->name('notification-pagination');
    Route::get('/detail/{id}', 'NotificationController@show')->name('notification-show');
    Route::post('/count', 'NotificationController@count')->name('notification-count');
});
