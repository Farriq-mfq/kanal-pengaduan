<?php

use App\Http\Controllers\DaftarAduanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\RolesManagementController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;


include_once __DIR__ . '/front.php';

Route::prefix('kanal')->group(function () {
    Route::middleware('auth')->group(function () {
        // dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/stats/count', [DashboardController::class, 'json_stats_count'])->name('dashboard.json_stats_count');
        Route::get('/stats/aduan', [DashboardController::class, 'json_stats_aduan'])->name('dashboard.json_stats_aduan');

        Route::put('/users/{id}/password', [UserManagementController::class, 'update_password'])->name('users.update.password');
        Route::resource('users', UserManagementController::class);
        Route::resource('roles', RolesManagementController::class);
        Route::resource('klasifikasi', KlasifikasiController::class);
        Route::resource("kategori", KategoriController::class);
        // aduan
        Route::prefix('aduan')->group(function () {
            Route::get('/', [DaftarAduanController::class, 'index'])->name('aduan.index');
            Route::get('/{id}/detail', [DaftarAduanController::class, 'show'])->name('aduan.detail');
            Route::get('{id}/detail/print', [DaftarAduanController::class, 'print'])->name('aduan.detail.print');
            // ADMIN
            Route::delete('/{id}/destroy', [DaftarAduanController::class, 'destroy'])->name('aduan.destroy')->middleware('permission:aduan destroy');
            Route::patch('/{id}/accept', [DaftarAduanController::class, 'accept'])->name('aduan.accept')->middleware('permission:aduan accept');
            Route::patch('/{id}/reject', [DaftarAduanController::class, 'reject'])->name('aduan.reject')->middleware('permission:aduan reject');
            // TIM PENANGANAN
            Route::patch('/{id}/continue', [DaftarAduanController::class, 'continue'])->name('aduan.continue')->middleware('role:tim penanganan');
            Route::patch('/{id}/direct', [DaftarAduanController::class, 'direct_answer'])->name('aduan.direct')->middleware('role:tim penanganan');
            Route::patch('/{id}/tindak_lanjut', [DaftarAduanController::class, 'tindak_lanjut'])->name('aduan.tindak_lanjut')->middleware('role:tim penanganan');
            Route::patch('/{id}/telaah', [DaftarAduanController::class, 'telaah'])->name('aduan.telaah')->middleware('role:tim penanganan');
            Route::get('/{id}/kepala_bidang', [DaftarAduanController::class, 'kepala_bidang'])->name('aduan.kepala_bidang')->middleware('role:tim penanganan');
            // KEPALA BIDANG
            Route::patch('/{id}/verify/kepala_bidang', [DaftarAduanController::class, 'verify_kepala_bidang'])->name('aduan.verify_kepala_bidang')->middleware('role:kepala bidang');
            Route::patch('/{id}/revisi/kepala_bidang', [DaftarAduanController::class, 'revisi_tindak_lanjut'])->name('aduan.revisi_tindak_lanjut')->middleware('role:kepala bidang');
            Route::patch('/{id}/verify/kepala_dinas', [DaftarAduanController::class, 'verify_kepala_dinas'])->name('aduan.verify_kepala_dinas')->middleware('role:kepala dinas');
        });

        Route::get('/tracking', [TrackingController::class, 'tracking'])->name('tracking');
        Route::post('/tracking', [TrackingController::class, 'json_tracking_result'])->name('tracking.json_tracking_result');
        // rekap
        Route::get('/rekap', [RekapController::class, 'rekap'])->name('rekap');
        Route::get('/rekap/export', [RekapController::class, 'export'])->name('rekap.export');
        // masyarakat
        Route::get('masyarakat', [MasyarakatController::class, 'index'])->name('masyarakat.index');
        Route::get('masyarakat/export', [MasyarakatController::class, 'export'])->name('masyarakat.export');
    });

    include_once __DIR__ . '/auth.php';
});
