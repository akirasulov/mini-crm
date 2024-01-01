<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/sync', [PermissionController::class, 'sync'])->name('permission.sync');
    Route::post('/permission/assign', [PermissionController::class, 'assign'])->name('permission.assign');
    Route::post('/permission/remove', [PermissionController::class, 'remove'])->name('permission.remove');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permission/store', [PermissionController::class, 'storePermission'])->name('permission.store');
    Route::post('/role/store', [PermissionController::class, 'storeRole'])->name('role.store');
    Route::post('/role/destroy', [RoleController::class, 'destroy'])->name('role.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/edit/{user:id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::post('/users/role/{user:id}', [UserController::class, 'assignRole'])->name('users.role');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/permission/{user:id}', [UserController::class, 'assignPermission'])->name('users.permission');
    Route::patch('/users/update/{user:id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/destroy/{user:id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
