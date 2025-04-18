<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Define resource for income, expense, and goals
    Route::resource('/income', IncomeController::class);
    Route::get('/income/{id}/edit', [IncomeController::class, 'edit'])->name('income.edit');
    Route::resource('/expense', ExpenseController::class);
    Route::resource('/goals', GoalController::class);
    Route::resource('categories', CategoryController::class);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Route for updating progress of a goal
    Route::put('/goals/{goal}/update-progress', [GoalController::class, 'updateProgress'])->name('goals.updateProgress');
});

require __DIR__.'/auth.php';
