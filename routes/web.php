<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FrontController;
use App\Models\Article;

// ===== Front Routes (Public) =====
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/articles', [FrontController::class, 'articles'])->name('front.articles');
Route::get('/articles/{id}', [FrontController::class, 'show'])->name('front.articles.show');
Route::get('/contact', [FrontController::class, 'contact'])->name('front.contact');

// ===== Auth Routes =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect based on role
Route::get('/dashboard', [AuthController::class, 'redirectDashboard'])->middleware('auth')->name('redirect.dashboard');

// ===== Admin Routes =====
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $articles = Article::all();
        return view('dashboard.admin', compact('articles'));
    })->name('admin.dashboard');

    // Article management (Admin)
    Route::get('/admin/articles/manage', [ArticleController::class, 'index'])->name('admin.articles.manage');
    Route::get('/admin/articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
    Route::post('/admin/articles/store', [ArticleController::class, 'store'])->name('admin.articles.store');
    Route::get('/admin/articles/edit/{id}', [ArticleController::class, 'edit'])->name('admin.articles.edit');
    Route::put('/admin/articles/update/{id}', [ArticleController::class, 'update'])->name('admin.articles.update');
    Route::delete('/admin/articles/delete/{id}', [ArticleController::class, 'destroy'])->name('admin.articles.delete');
    Route::get('/admin/articles/approval', [ArticleController::class, 'approval'])->name('articles.approval');
    Route::put('/admin/articles/update-status/{id}', [ArticleController::class, 'updateStatus'])->name('articles.updateStatus');

    // Admin article detail view
    Route::get('/admin/articles/show/{id}', [ArticleController::class, 'show'])->name('admin.articles.show');
});

// ===== Author Routes =====
Route::middleware(['auth', 'role:author'])->group(function () {
    Route::get('/author/dashboard', function () {
        return view('dashboard.author');
    })->name('author.dashboard');
});

// ===== Reader Routes =====
Route::middleware(['auth', 'role:reader'])->group(function () {
    Route::get('/reader/dashboard', function () {
        return view('dashboard.reader');
    })->name('reader.dashboard');
});

// ===== Middleware for Role Check =====
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});

// ===== Fallback Route =====
Route::fallback(function () {
    return view('errors.404');
});
