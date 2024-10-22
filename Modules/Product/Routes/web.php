<?php

use App\Http\Middleware\AuthPassport;
use Illuminate\Support\Facades\Route;
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

Route::POST('/product/get-products', 'ProductController@getProducts')->name('getProducts');
Route::get('/product', 'ProductController@index');
Route::get('product/{id}', 'ProductController@show'); 
