<?php

use App\Http\Controllers\FrontAuthController;
use App\Http\Controllers\FrontController;

Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/about', [FrontController::class, 'about'])->name('about');


Route::get("/login", [FrontAuthController::class, "index"])->name("front.login")->middleware("guest_masyarakat");
Route::post("/login", [FrontAuthController::class, "store"])->name("front.login.store")->middleware("guest_masyarakat");
Route::get("/register", [FrontAuthController::class, "register"])->name("front.register")->middleware("guest_masyarakat");
Route::post("/register", [FrontAuthController::class, "register_store"])->name("front.register.store")->middleware("guest_masyarakat");
Route::get("/verify/{token}", [FrontAuthController::class, "verify"])->name("front.verify")->middleware("guest_masyarakat");

Route::post("/logout", [FrontAuthController::class, "logout"])->name("front.logout")->middleware("auth_masyarakat");
