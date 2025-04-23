<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoogleController;

Route::get('auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/', function () {
    return redirect('/dashboard');
});
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
    Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/income', IncomeController::class);
    Route::get('/income/{id}/edit', [IncomeController::class, 'edit'])->name('income.edit');
    Route::resource('/expense', ExpenseController::class);
    Route::resource('/goals', GoalController::class);
    Route::get('/goals/{goal}', [GoalController::class, 'show'])->name('goals.show');
    Route::post('/goals/{goal}/transactions', [GoalController::class, 'storeTransaction'])->name('goals.storeTransaction');
    Route::resource('categories', CategoryController::class);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Route for updating progress of a goal
    Route::put('/goals/{goal}/update-progress', [GoalController::class, 'updateProgress'])->name('goals.updateProgress');
});
Route::get('/mobile/login', function (Request $request) {
    $token = $request->query('token');

    $accessToken = PersonalAccessToken::findToken($token);

    if (! $accessToken) {
        return redirect('/login')->with('error', 'Token tidak valid.');
    }

    Auth::login($accessToken->tokenable);

    return redirect('/dashboard');
});
require __DIR__.'/auth.php';
