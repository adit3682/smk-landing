<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpmbController;
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\TransparansiController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil-sekolah', [ProfilSekolahController::class, 'index'])->name('profil-sekolah');
Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('artikel.show');
Route::get('/jurusan/{slug}', [JurusanController::class, 'show'])->name('jurusan.show');
Route::get('/transparansi', [TransparansiController::class, 'index'])->name('transparansi');
 Route::get('/spmb', [SpmbController::class, 'index'])->name('spmb');