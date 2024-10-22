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

// Route::middleware([AuthPassport::class])->prefix('dashboard')->group(function () {
//     // Route::get('/', 'DashboardController@index')->name('dashboard');
// });
Route::POST('/dashboard/products/recommendation', 'DashboardController@ProductsRecommend')->name('dashobard.productsRecommend');
Route::POST('/dashboard/products/nearest', 'DashboardController@productsNearest')->name('dashobard.productsNearest');
Route::POST('/dashboard/outlet/nearest', 'DashboardController@outletNearest')->name('dashobard.outletNearest');
Route::POST('/dashboard/search', 'DashboardController@search')->name('dashboard.search');

Route::get('/', 'DashboardController@index')->name('dashboard');
