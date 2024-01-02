<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $users = User::whereHas('roles', function (Builder $query) {
        $query->whereIn('name', ['operator', 'back-office']);
    })
        ->get()
        ->transform(fn($user) => [
            'id' => $user->id,
            'fullname' => $user->fullname,
            'login' => $user->login,
            'email' => $user->email,
        ]);
    return $users;
    // return UserResource::collection($users);
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissios.index');
    Route::post('/permission/assign', [PermissionController::class, 'assign'])->name('permissios.assign');
    Route::post('/permission/remove', [PermissionController::class, 'remove'])->name('permissios.remove');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permissios.create');
    Route::post('/permission/store', [PermissionController::class, 'storePermission'])->name('permissios.store');

    Route::post('/comments/store/{post:id}', CommentController::class)->name('comments.store');

    Route::post('/role/store', [PermissionController::class, 'storeRole'])->name('roles.store');
    Route::post('/role/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/edit/{post:id}', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/update/{post:id}', [PostController::class, 'update'])->name('posts.update');
    Route::get('/posts/export', [PostController::class, 'export'])->name('posts.export');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/edit/{user:id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::post('/users/role/{user:id}', [UserController::class, 'assignRole'])->name('users.role');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/permission/{user:id}', [UserController::class, 'assignPermission'])->name('users.permission');
    Route::patch('/users/update/{user:id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/avatar/{user:id}', [UserController::class, 'updateAvatar'])->name('users.avatar');
    Route::delete('/users/destroy/{user:id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
