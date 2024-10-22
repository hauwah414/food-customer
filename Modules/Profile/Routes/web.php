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

Route::middleware([AuthPassport::class])->prefix('profile')->group(function () {
    Route::get('/', 'ProfileController@index')->name('profile');
    Route::get('/edit', 'ProfileController@edit')->name('profile-edit');
    Route::post('/update/info', 'ProfileController@updateInfo')->name('profile-updateInfo');

    Route::post('/update/photo', 'ProfileController@updatePhoto')->name('profile-updatePhoto');
    Route::post('/update/address', 'ProfileController@updateAddress')->name('profile-updateAddress');

    Route::post('/ajaxCities', 'ProfileController@ajaxCities')->name('profile-ajaxCities');
    Route::post('/ajaxDistricts', 'ProfileController@ajaxDistricts')->name('profile-ajaxDistricts');
    Route::post('/ajaxSubDistric', 'ProfileController@ajaxSubDistric')->name('profile-ajaxSubDistric');
});
