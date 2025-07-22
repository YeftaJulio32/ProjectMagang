<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


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
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/create-user', [AdminController::class, 'createUser'])->name('admin.profile.create');
    Route::post('/store-user', [AdminController::class, 'storeUser'])->name('admin.store-user');
    Route::delete('/delete-user/{user}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');

    // Admin profile management
    Route::get('/profile/{id}', [AdminController::class, 'showProfile'])->name('admin.profile.show');
    Route::get('/profile/{id}/edit', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::put('/profile/{id}', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
});

// User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.profile.show');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
});

Route::get('/admin/komentar', [AdminController::class, 'komentarManajemen'])->name('admin.komentar.index');

Route::delete('/admin/komentar/{id}', [AdminController::class, 'destroyComment'])->name('admin.komentar.destroy');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Dashboard Route - Redirect based on role
Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.profile.show');
        }
    }
    return redirect()->route('login');
})->name('dashboard')->middleware('auth');
