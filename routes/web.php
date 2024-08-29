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

// Rutas de config de params
Route::get('/params', 'App\Http\Controllers\paramsController@index')->name('configParams');
Route::post('/saveParams', 'App\Http\Controllers\paramsController@saveParams')->name('saveParams');

// Rutas de config de outputs
Route::get('/outputs', 'App\Http\Controllers\OutputsController@index')->name('configOutputs');
Route::post('/saveOutput', 'App\Http\Controllers\OutputsController@saveOutput')->name('saveOutput');
Route::post('/newOutput', 'App\Http\Controllers\OutputsController@newOutput')->name('newOutput');
Route::post('/deleteOutput', 'App\Http\Controllers\OutputsController@deleteOutput')->name('deleteOutput');

// Análisis de video
Route::post('/analisis', 'App\Http\Controllers\dataController@analizarVideo')->name('analizarVideo');

Route::post('/exportarPDF', 'App\Http\Controllers\dataController@exportarPDF')->name('exportarPDF');

