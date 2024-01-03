<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::post('/permission/assign', [PermissionController::class, 'assign'])->name('permissions.assign');
Route::post('/permission/remove', [PermissionController::class, 'remove'])->name('permissions.remove');
Route::get('/permission/create', [PermissionController::class, 'create'])->name('permissions.create');
Route::post('/permission/store', [PermissionController::class, 'storePermission'])->name('permissions.store');
Route::post('/role/store', [PermissionController::class, 'storeRole'])->name('roles.store');
Route::post('/role/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');
});