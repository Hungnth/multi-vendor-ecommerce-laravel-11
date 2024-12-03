<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;

Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
