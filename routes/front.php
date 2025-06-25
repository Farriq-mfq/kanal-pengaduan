<?php

use App\Http\Controllers\FrontAduanController;
use App\Http\Controllers\FrontAuthController;
use App\Http\Controllers\FrontController;

Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/panduan-kategori', [FrontController::class, 'panduan_kategori'])->name('panduan.kategori');
Route::get('/profile', [FrontController::class, 'profile'])->name('front.profile')->middleware('auth_masyarakat');
Route::patch('/profile/update', [FrontAuthController::class, 'update_profile'])->name('front.auth.update_profile')->middleware('auth_masyarakat');


Route::get("/login", [FrontAuthController::class, "index"])->name("front.login")->middleware("guest_masyarakat");
Route::post("/login", [FrontAuthController::class, "store"])->name("front.login.store")->middleware("guest_masyarakat");
Route::get("/register", [FrontAuthController::class, "register"])->name("front.register")->middleware("guest_masyarakat");
Route::post("/register", [FrontAuthController::class, "register_store"])->name("front.register.store")->middleware("guest_masyarakat");
Route::get("/verify/{token}", [FrontAuthController::class, "verify"])->name("front.verify")->middleware("guest_masyarakat");
Route::get('/forgot-password', [FrontAuthController::class, 'forgot_password'])->name('front.auth.forgot_password');
Route::post('/forgot-password/store', [FrontAuthController::class, 'forgot_password_store'])->name('front.auth.forgot_password.store');
Route::get('/reset-password/{token}', [FrontAuthController::class, 'reset_password'])->name('front.auth.reset_password');
Route::post('/reset-password/{token}/store', [FrontAuthController::class, 'reset_password_store'])->name('front.auth.reset_password.store');


Route::post("/logout", [FrontAuthController::class, "logout"])->name("front.logout")->middleware("auth_masyarakat");


Route::prefix('aduan')->group(function () {
    Route::get('/', [FrontAduanController::class, 'index'])->name('front.aduan');
    Route::get('/datatable', [FrontAduanController::class, 'listAduan'])->name('front.aduan.data');
    Route::post("/store", [FrontAduanController::class, "store"])->name("front.aduan.store");
    Route::get("/tracking", [FrontAduanController::class, "tracking"])->name("front.aduan.tracking")->middleware("auth_masyarakat");
    Route::get("/revisi/{id}", [FrontAduanController::class, "revisi"])->name("front.aduan.revisi");
    Route::get('/kategori', [FrontAduanController::class, 'kategori'])->name('front.aduan.kategori');
});

