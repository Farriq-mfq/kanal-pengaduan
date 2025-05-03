<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store')->middleware('guest');

    Route::delete('/logout', [AuthController::class, 'destroy'])->name('logout')->middleware('auth');
});
