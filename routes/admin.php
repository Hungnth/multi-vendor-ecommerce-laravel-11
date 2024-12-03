<?php


use App\Http\Controllers\Backend\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;

Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

// Profile route
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::post('profile/update', [ProfileController::class, 'update_profile'])->name('profile.update');
Route::post('profile/update/password', [ProfileController::class, 'update_password'])->name('password.update');
