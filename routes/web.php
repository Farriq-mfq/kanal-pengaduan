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
            Route::patch('/{id}/accept', [DaftarAduanController::class, 'accept'])->name('aduan.accept');
            Route::patch('/{id}/reject', [DaftarAduanController::class, 'reject'])->name('aduan.reject');
        });
    });

    include_once __DIR__ . '/auth.php';
});
