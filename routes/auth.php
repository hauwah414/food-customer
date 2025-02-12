<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login-check', [LoginController::class, 'loginCheck'])->name('loginCheck');

Route::get('/signup', [RegisterController::class, 'signup'])->name('register');
Route::post('/signup', [RegisterController::class, 'signupPost'])->name('registerPost');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [LoginController::class, 'login'])->name('login');
