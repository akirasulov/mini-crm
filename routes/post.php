<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/edit/{post:id}', [PostController::class, 'edit'])->name('posts.edit');
Route::patch('/posts/update/{post:id}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/destroy/{post:id}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::put('/posts/restore/{post:id}', [PostController::class, 'restore'])->name('posts.restore');
Route::get('/posts/export', [PostController::class, 'export'])->name('posts.export');
Route::post('/comments/store/{post:id}', CommentController::class)->name('comments.store');
});