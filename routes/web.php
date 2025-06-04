<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarListController;
use App\Http\Controllers\RemoveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Authentication routes
require __DIR__.'/auth.php';

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // ADMIN car management routes
    Route::post('car/remove', [RemoveController::class, 'deleteCar'])->name('admin.car.remove');
    Route::post('car/update/{id}', [CarListController::class, 'update'])->name('admin.car.update');
    // ADMIN User management routes
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/users/store', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [RemoveController::class, 'destroy'])->name('admin.users.destroy');
});

// Authenticated user routes (both admin and regular users)
Route::middleware(['auth', 'verified'])->group(function () {
    // Smart dashboard that redirects based on user type
    Route::get('/dashboard', function () {
        return auth()->user()->is_admin 
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // User profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User routes
    Route::prefix('user')->group(function () {
        // Dashboard and booking routes
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::post('/bookings', [BookingController::class, 'store'])->name('user.bookings.store');
        Route::post('/user/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('user.bookings.cancel');
        // Car management routes (consider if these should be admin-only)
        Route::get('/addlist', [CarListController::class, 'create'])->name('admin.car.add');
        Route::post('/addlist', [CarListController::class, 'store'])->name('cars.store');
    });
});