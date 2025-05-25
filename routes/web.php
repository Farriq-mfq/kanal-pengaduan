<?php

use App\Http\Controllers\DaftarAduanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\RolesManagementController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;


include 'front.php';

Route::prefix('kanal')->group(function () {
    Route::middleware('auth')->group(function () {
        // dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/stats/count', [DashboardController::class, 'json_stats_count'])->name('dashboard.json_stats_count');
        Route::get('/stats/aduan', [DashboardController::class, 'json_stats_aduan'])->name('dashboard.json_stats_aduan');

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
            Route::patch('/{id}/direct', [DaftarAduanController::class, 'direct_answer'])->name('aduan.direct')->middleware('permission:aduan direct');
            Route::patch('/{id}/tindak_lanjut', [DaftarAduanController::class, 'tindak_lanjut'])->name('aduan.tindak_lanjut')->middleware('permission:aduan tindak_lanjut');

            Route::patch('/{id}/verify/kepala_bidang', [DaftarAduanController::class, 'verify_kepala_bidang'])->name('aduan.verify_kepala_bidang')->middleware('permission:kepala bidang');
        });

        Route::get('/tracking', [TrackingController::class, 'tracking'])->name('tracking');
        Route::post('/tracking', [TrackingController::class, 'json_tracking_result'])->name('tracking.json_tracking_result');

    });

    include_once __DIR__ . '/auth.php';
});
