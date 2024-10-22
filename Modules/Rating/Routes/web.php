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

Route::middleware([AuthPassport::class])->prefix('rating')->group(function () {
    Route::get('/{slug}', 'RatingController@show');
    Route::post('/create', 'RatingController@create');
});
