<?php

use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'role'])->group(function () {
    Route::post('/upload-image', [ImageUploadController::class, 'store'])
        ->middleware('throttle:20,1')
        ->name('image.upload');

    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
});

Route::get('/', [PostController::class, 'index'])->name('dashboard');
Route::get('/@{user:username}/{post:slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/@{user:username}', [PublicProfileController::class, 'show'])->name('profile.show');
Route::get('/category/{category}', [PostController::class, 'categorize'])->name('post.categorize');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('throttle:10,1')
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
