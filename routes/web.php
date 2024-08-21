<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {return view('auth.login.index');});
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/home', function () {return view('home');});


Route::resource('reminder', ReminderController::class);

Route::resource('barang', BarangController::class);
Route::resource('jenis_barang', JenisBarangController::class);
Route::resource('laporan', LaporanController::class);
Route::get('laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');
Route::get('laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
Route::put('laporan/{laporan}', [LaporanController::class, 'updateStatus'])->name('laporan.update');

