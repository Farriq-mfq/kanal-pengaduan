<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store')->middleware('guest');

    Route::delete('/logout', [AuthController::class, 'destroy'])->name('logout')->middleware('auth');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::patch('/profile', [AuthController::class, 'update_profile'])->name('profile.update');
});
