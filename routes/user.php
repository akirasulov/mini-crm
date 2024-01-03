<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::get('/users/edit/{user:id}', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/restore/{user:id}', [UserController::class, 'restore'])->name('users.restore');
Route::post('/users/role/{user:id}', [UserController::class, 'assignRole'])->name('users.role');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::post('/users/permission/{user:id}', [UserController::class, 'assignPermission'])->name('users.permission');
Route::patch('/users/update/{user:id}', [UserController::class, 'update'])->name('users.update');
Route::post('/users/avatar/{user:id}', [UserController::class, 'updateAvatar'])->name('users.avatar');
Route::delete('/users/destroy/{user:id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
});