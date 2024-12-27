<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

use Modules\ModuleManagement\Controllers\ModuleController;

Route::middleware(['auth'])->prefix('modules')->name('modules.')->group(function () {
    Route::get('/', [ModuleController::class, 'index'])->name('index');
    Route::post('/install', [ModuleController::class, 'install'])->name('install');
    Route::post('/{id}/toggle', [ModuleController::class, 'toggleStatus'])->name('toggle');
    Route::delete('/{id}', [ModuleController::class, 'delete'])->name('delete');
    
    // Create Module routes
    Route::get('/create', [ModuleController::class, 'create'])->name('create');
    Route::post('/store', [ModuleController::class, 'store'])->name('store');
    Route::delete('/{module}', [ModuleController::class, 'destroy'])->name('destroy');
});


