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

// Route::middleware([AuthPassport::class])->prefix('outlet')->group(function () {
Route::get('/outlet', 'OutletController@index');
Route::get('/outlet/{slug}', 'OutletController@showOutlet')->name('showOutlet');
Route::post('/outlet/search', 'OutletController@search')->name('search');
// });
