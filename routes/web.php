<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [ListingController::class, 'index'])->name('home');
Route::inertia('/about', 'About')->name('about');

Route::resource('listing', ListingController::class);

// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->middleware('password.confirm')->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])
    ->controller(AdminController::class)
    ->group(function () {
        Route::get('/admin', 'index')->name('admin.index');
        Route::get('/users/{user}', 'show')->name('user.show');
        Route::put('/admin/{user}/role', 'role')->name('admin.role');
        Route::put('/listing/{listing}/approve', 'approve')->name('admin.approve');
    });

Route::post('/set-locale', function (Request $request) {
    $locale = $request->locale;
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return back();
});

require __DIR__ . "/auth.php";
