<?php

use Illuminate\Support\Facades\Route;

use Modules\FarmerManagement\Controllers\FarmerController;

// Define the FarmerManagement module routes
Route::middleware(['web'])->group(function () {
    Route::resource('farmers', FarmerController::class);
});

Route::prefix('farmers')->name('farmers.')->group(function () {
    Route::get('/', [FarmerController::class, 'index'])->name('index');
    Route::get('/create', [FarmerController::class, 'create'])->name('create');
    Route::post('/', [FarmerController::class, 'store'])->name('store');
    Route::get('/{farmer}/edit', [FarmerController::class, 'edit'])->name('edit');
    Route::put('/{farmer}', [FarmerController::class, 'update'])->name('update');
    Route::delete('/{farmer}', [FarmerController::class, 'destroy'])->name('destroy');
    Route::get('/farmers/{id}', [FarmerController::class, 'show'])->name('farmers.show');
});



