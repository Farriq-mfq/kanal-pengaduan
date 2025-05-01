<?php

use App\Http\Controllers\RolesManagementController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard');
})->name('dashboard');


Route::resource('users', UserManagementController::class);
Route::resource('roles', RolesManagementController::class);
