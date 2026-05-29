<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifikasiSpjController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SbmController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SptController;
use App\Http\Controllers\DashboardController;

// Route untuk tamu (belum login)
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'prosesLogin']);

// Route yang DIKUNCI (Hanya bisa diakses setelah Login)
Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect('/dashboard');
        // Mengambil semua data pegawai dari database
        $data_pegawai = App\Models\Pegawai::orderBy('nama', 'asc')->get();
        return view('form_spj', compact('data_pegawai'));
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/evaluasi-spj', [VerifikasiSpjController::class, 'evaluasi'])->name('evaluasi.spj');
    Route::get('/riwayat-spj', [VerifikasiSpjController::class, 'riwayat'])->name('riwayat.spj');
    Route::delete('/riwayat-spj/{id}', [VerifikasiSpjController::class, 'destroy'])->name('spj.destroy');
    Route::get('/cetak-kwitansi/{id}', [VerifikasiSpjController::class, 'cetakKwitansi'])->name('cetak.kwitansi');
    Route::resource('sbm', App\Http\Controllers\SbmController::class);
    Route::resource('pegawai', App\Http\Controllers\PegawaiController::class);
    
    // Rute untuk Modul SPT
    Route::get('/spt', [SptController::class, 'index'])->name('spt.index');
    Route::post('/spt', [SptController::class, 'store'])->name('spt.store');
    Route::get('/spt/cetak/{id}', [SptController::class, 'cetak'])->name('spt.cetak');
    // Rute untuk Edit, Update, dan Hapus SPT
    Route::get('/spt/{id}/edit', [SptController::class, 'edit'])->name('spt.edit');
    Route::put('/spt/{id}', [SptController::class, 'update'])->name('spt.update');
    Route::delete('/spt/{id}', [SptController::class, 'destroy'])->name('spt.destroy');

    // Route untuk Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
