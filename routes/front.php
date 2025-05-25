<?php

Route::get('/', function () {
    return view('front.index');
})->name('home');
