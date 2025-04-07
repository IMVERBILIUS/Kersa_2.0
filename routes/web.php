<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Models\Article;

// Public Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect based on role
Route::get('/dashboard', [AuthController::class, 'redirectDashboard'])->middleware('auth')->name('redirect.dashboard');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $articles = Article::latest()->take(5)->get(); // bisa disesuaikan jumlahnya
        return view('dashboard.admin', compact('articles'));
    })->name('admin.dashboard');

    // Article management (Admin)
    Route::get('/admin/articles/manage', [ArticleController::class, 'index'])->name('admin.articles.manage');
    Route::get('/admin/articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
    Route::post('/admin/articles/store', [ArticleController::class, 'store'])->name('admin.articles.store');
    Route::get('/admin/articles/edit/{id}', [ArticleController::class, 'edit'])->name('admin.articles.edit');
    Route::put('/admin/articles/update/{id}', [ArticleController::class, 'update'])->name('admin.articles.update');
    Route::delete('/admin/articles/delete/{id}', [ArticleController::class, 'destroy'])->name('admin.articles.delete');
});

// Author Routes
Route::middleware(['auth', 'role:author'])->group(function () {
    Route::get('/author/dashboard', function () {
        return view('dashboard.author');
    });
});

// Reader Routes
Route::middleware(['auth', 'role:reader'])->group(function () {
    Route::get('/reader/dashboard', function () {
        return view('dashboard.reader');
    });
});
