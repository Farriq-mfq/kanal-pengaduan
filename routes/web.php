<?php

use App\Http\Controllers\DaftarAduanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\RolesManagementController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;



Route::prefix('kanal')->group(function () {
    Route::middleware('auth')->group(function () {
        // dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserManagementController::class);
        Route::resource('roles', RolesManagementController::class);
        Route::resource('klasifikasi', KlasifikasiController::class);
        // aduan
        Route::prefix('aduan')->group(function () {
            Route::get('/', [DaftarAduanController::class, 'index'])->name('aduan.index');
            Route::get('/{id}/detail', [DaftarAduanController::class, 'show'])->name('aduan.detail');
            Route::delete('/{id}/destroy', [DaftarAduanController::class, 'destroy'])->name('aduan.destroy');
            // ->middleware('permission:aduan destroy')
            Route::patch('/{id}/accept', [DaftarAduanController::class, 'accept'])->name('aduan.accept')->middleware('permission:aduan accept');
            Route::patch('/{id}/reject', [DaftarAduanController::class, 'reject'])->name('aduan.reject')->middleware('permission:aduan reject');
            Route::patch('/{id}/continue', [DaftarAduanController::class, 'continue'])->name('aduan.continue')->middleware('permission:aduan continue');
            Route::patch('/{id}/verify/kepala_bidang', [DaftarAduanController::class, 'verify_kepala_bidang'])->name('aduan.verify_kepala_bidang')->middleware('permission:kepala bidang');
        });
    });

    include_once __DIR__ . '/auth.php';
});
