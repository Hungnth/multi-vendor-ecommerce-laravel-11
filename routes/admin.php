<?php


use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;

Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

// Profile route
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::post('profile/update', [ProfileController::class, 'update_profile'])->name('profile.update');
Route::post('profile/update/password', [ProfileController::class, 'update_password'])->name('password.update');

// Slider route
Route::resource('slider', SliderController::class);

// Category route
Route::put('change-status', [CategoryController::class, 'change_status'])->name('category.change-status');
Route::resource('category', CategoryController::class);

// Sub-category route
Route::put('sub-category/change-status', [SubCategoryController::class, 'change_status'])->name('sub-category.change-status');
Route::resource('sub-category', SubCategoryController::class);

// Child-category route
Route::put('child-category/change-status', [ChildCategoryController::class, 'change_status'])->name('child-category.change-status');
Route::get('get-sub-categories', [ChildCategoryController::class, 'get_sub_categories'])->name('get-sub-categories');
Route::resource('child-category', ChildCategoryController::class);

// Brand route
Route::put('brand/change-status', [BrandController::class, 'change_status'])->name('brand.change-status');
Route::resource('brand', BrandController::class);

// Vendor Profile route
Route::resource('vendor-profile', AdminVendorProfileController::class);

// Products route
Route::get('product/get-sub-categories', [ProductController::class, 'get_sub_categories'])->name('product.get-sub-categories');
Route::get('product/get-child-categories', [ProductController::class, 'get_child_categories'])->name('product.get-child-categories');
Route::resource('products', ProductController::class);
Route::resource('products-image-gallery', ProductImageGalleryController::class);
