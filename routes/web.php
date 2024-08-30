<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login.index');
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/home', function () {
    return view('home');
})->middleware('auth');

Route::get('/home', [LaporanController::class, 'showHome'])->name('home')->middleware('auth');


Route::resource('laporan', LaporanController::class)->middleware('auth');
Route::put('laporan/{laporan}/status', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus')->middleware('auth');
Route::get('perbaikan', [PerbaikanController::class, 'index'])->name('perbaikan.index')->middleware('auth');
Route::patch('perbaikan/{laporan}/status', [PerbaikanController::class, 'updateStatus'])->name('perbaikan.updateStatus')->middleware('auth');


    Route::resource('reminder', ReminderController::class)->middleware('auth');
    Route::resource('barang', BarangController::class)->middleware('auth');
    Route::resource('jenis_barang', JenisBarangController::class)->middleware('auth');
    Route::resource('users', UserController::class)->middleware('auth');

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::post('/laporan/{id}/update-status', [LaporanController::class, 'updateStatus'])->name('laporan.update-status');
