<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });
});

Route::middleware(['auth', 'role:farmer'])->group(function () {
    Route::get('/farmer', function () {
        return view('farmer.dashboard');
    });
});

// Include Loan Management module routes
if (file_exists(base_path('modules/LoanManagement/Routes/web.php'))) {
    require base_path('modules/LoanManagement/Routes/web.php');
}

// Include Farm Management module routes
if (file_exists(base_path('modules/FarmerManagement/Routes/web.php'))) {
    require base_path('modules/FarmerManagement/Routes/web.php');
}

if (file_exists(base_path('modules/ModuleManagement/Routes/web.php'))) {
    require base_path('modules/ModuleManagement/Routes/web.php');
}

