<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProductImageGalleryController;
use App\Http\Controllers\Backend\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
Route::get('profile', [VendorProfileController::class, 'index'])->name('profile');
Route::put('profile', [VendorProfileController::class, 'update_profile'])->name('profile.update'); // vendor.profile.update
Route::post('profile', [VendorProfileController::class, 'update_password'])->name('profile.update.password');

// Vendor Shop Profile route
Route::resource('shop-profile', VendorShopProfileController::class);

// Vendor Product routes
Route::get('product/get-sub-categories', [VendorProductController::class, 'get_sub_categories'])->name('product.get-sub-categories');
Route::get('product/get-child-categories', [VendorProductController::class, 'get_child_categories'])->name('product.get-child-categories');
Route::resource('products', VendorProductController::class);

// Vendor Product Image Gallery route
Route::resource('products-image-gallery', VendorProductImageGalleryController::class);

