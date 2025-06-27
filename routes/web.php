<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🟢 Ini kita ubah: Homepage diarahkan ke controller
Route::get('/', [NewsController::class, 'index'])->name('news.index');

// Detail berita
Route::get('/berita/{id}', [NewsController::class, 'show'])->name('news.show');

// Kategori berita
Route::get('/kategori/{kategori}', [NewsController::class, 'kategori'])->name('news.kategori');

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
