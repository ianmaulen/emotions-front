<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/analisis', 'App\Http\Controllers\dataController@analizarVideo')->name('analizarVideo');
Route::get('/params', 'App\Http\Controllers\paramsController@index')->name('configParams');
Route::post('/saveParams', 'App\Http\Controllers\paramsController@saveParams')->name('saveParams');