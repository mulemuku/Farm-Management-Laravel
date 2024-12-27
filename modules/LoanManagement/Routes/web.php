<?php

use Illuminate\Support\Facades\Route;

use Modules\LoanManagement\Controllers\LoanController;


Route::prefix('loan-management')->group(function () {
    Route::get('/', [LoanController::class, 'index'])->name('loan.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::resource('loans', \Modules\LoanManagement\Controllers\LoanController::class);
});




Route::middleware(['auth'])->prefix('loans')->name('loans.')->group(function () {
    Route::get('/reports', [LoanController::class, 'report'])->name('reports');
    Route::get('/', [LoanController::class, 'index'])->name('index');
    Route::get('create', [LoanController::class, 'create'])->name('create');
    Route::post('store', [LoanController::class, 'store'])->name('store');
    Route::post('{loan}/approve', [LoanController::class, 'approve'])->name('approve');
    Route::post('{loan}/reject', [LoanController::class, 'reject'])->name('reject');
    Route::post('{loan}/repay', [LoanController::class, 'repay'])->name('repay');
   
});

