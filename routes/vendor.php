<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProductImageGalleryController;
use App\Http\Controllers\Backend\VendorProductVariantController;
use App\Http\Controllers\Backend\VendorProductVariantItemController;
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

// Product Variant route
Route::put('products-variant/change-status', [VendorProductVariantController::class, 'change_status'])->name('products-variant.change-status');
Route::resource('products-variant', VendorProductVariantController::class);

// Product Variant Item route
Route::get('products-variant-item/{product_id}/{variant_id}', [VendorProductVariantItemController::class, 'index'])->name('products-variant-item.index');
Route::get('products-variant-item/create/{product_id}/{variant_id}', [VendorProductVariantItemController::class, 'create'])->name('products-variant-item.create');
Route::post('products-variant-item', [VendorProductVariantItemController::class, 'store'])->name('products-variant-item.store');
Route::get('products-variant-item-edit/{variant_item_id}', [VendorProductVariantItemController::class, 'edit'])->name('products-variant-item.edit');
Route::put('products-variant-item-update/{variant_item_id}', [VendorProductVariantItemController::class, 'update'])->name('products-variant-item.update');
Route::delete('products-variant-item-delete/{variant_item_id}', [VendorProductVariantItemController::class, 'destroy'])->name('products-variant-item.destroy');
Route::put('products-variant-item-status/', [VendorProductVariantItemController::class, 'change_status'])->name('products-variant-item.change_status');

