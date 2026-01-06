<?php

use Illuminate\Support\Facades\Route;

//Admin
Route::get('/beranda', function () {
    return view('welcome');
})->name('beranda');

Route::get('/petani', function () {
    return view('admin.petani');
})->name('petani');

Route::get('/user', function () {
    return view('admin.user');
})->name('cara-kerja');

Route::get('/kontak', function () {
    return view('pages.kontak');
})->name('kontak');


Route::get('/katalog', function () {
    return view('pages.katalog');
})->name('katalog');

Route::get('/petani', function () {
    return view('admin.petani');
})->name('petani');

Route::get('/cara-kerja', function () {
    return view('pages.cara-kerja');
})->name('cara-kerja');

Route::get('/kontak', function () {
    return view('pages.kontak');
})->name('kontak');
