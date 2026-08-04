<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tasks CRUD Routes
    Route::resource('tasks', TaskController::class);
    // Custom route to toggle completed status
    Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

    // Categories CRUD Routes
    Route::resource('categories', CategoriesController::class);
   
    // Admin Management Routes
    Route::prefix('admin')->group(function () {
        Route::resource('roles', RoleController::class)->except(['show'])->middleware('can:manage roles');
        Route::middleware('can:manage users')->group(function () {
            Route::get('users', [AdminUserController::class, 'index'])->name('admin.users.index');
            Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
            Route::put('users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
        });
    });
});

require __DIR__.'/auth.php';
