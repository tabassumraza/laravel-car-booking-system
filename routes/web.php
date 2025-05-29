<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarListController;
use App\Http\Controllers\RemoveController;

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
    return view('auth.register');
});

// Authentication routes
require __DIR__.'/auth.php';


// Admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
   
     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     // Add more admin routes here
Route::post('car/remove', [RemoveController::class, 'deleteCar'])->name('admin.car.remove');
Route::put('car/update/{id}', [CarListController::class, 'update'])->name('admin.car.update');



});

// Authenticated user routes (both admin and regular users)
    

    Route::middleware(['auth', 'verified'])->group(function () {
    // Smart dashboard that redirects based on user type
    Route::get('/dashboard', function () {
        return auth()->user()->is_admin 
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // User profile routes dd(User::where('is_admin', true)->count())
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User dashboard and car routes
    Route::prefix('user')->group(function () {
        Route::get('/dashboard', function () {
            $cars = DB::table('carlists')->get();
            return view('user.dashboard', compact('cars'));
        })->name('user.dashboard');
        
        Route::get('/addlist', [CarListController::class, 'create'])->name('admin.car.add');
        Route::post('/addlist', [CarListController::class, 'store'])->name('cars.store');
    });
});