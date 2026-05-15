<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\AuthController;

// 1. GUEST ONLY
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.auth');
});

// 2. AUTH ONLY
Route::middleware(['auth'])->group(function () {
    
    // Dashboard & Home
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/detail/{kategori}/{id}', [DashboardController::class, 'show'])->name('surat.detail');

    // Surat Masuk
    Route::get('/surat-masuk', [SuratMasukController::class, 'index'])->name('surat-masuk.index');
    Route::post('/surat-masuk/store', [SuratMasukController::class, 'store'])->name('surat-masuk.store');
    Route::put('/surat-masuk/update/{id}', [SuratMasukController::class, 'update'])->name('surat-masuk.update');
    Route::delete('/surat-masuk/delete/{id}', [SuratMasukController::class, 'destroy'])->name('surat-masuk.destroy');

    // Surat Keluar
    Route::get('/surat-keluar', [SuratKeluarController::class, 'index'])->name('surat-keluar.index');
    Route::post('/surat-keluar/store', [SuratKeluarController::class, 'store'])->name('surat-keluar.store');
    Route::put('/surat-keluar/update/{id}', [SuratKeluarController::class, 'update'])->name('surat-keluar.update');
    Route::delete('/surat-keluar/delete/{id}', [SuratKeluarController::class, 'destroy'])->name('surat-keluar.destroy');

    // Operator (Proteksi dilakukan di dalam Controller)
    Route::resource('operator', OperatorController::class);

    // Logout
    Route::post('/logout', function (Illuminate\Http\Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});