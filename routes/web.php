<?php

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


Route::post('/pegawai/store', 'PegawaiController@store')->name('pegawai.store');
Route::post('/pegawai/print', 'PegawaiController@print')->name('pegawai.print');
Route::delete('/pegawai/destroy/{id}', 'PegawaiController@destroy')->name('pegawai.destroy');
Route::get('/pegawai/show/{id}', 'PegawaiController@show')->name('pegawai.show');
Route::get('/pegawai', 'PegawaiController@index')->name('pegawai');

// Route::resource('/pegawai', 'PegawaiController');
