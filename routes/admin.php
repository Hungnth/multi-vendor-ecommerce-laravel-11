<?php


use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\FlashSaleController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SellerProductController;
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
Route::put('product/change-status', [ProductController::class, 'change_status'])->name('product.change-status');
Route::resource('products', ProductController::class);

// Product Image Gallery route
Route::resource('products-image-gallery', ProductImageGalleryController::class);

// Product Variant route
Route::put('products-variant/change-status', [ProductVariantController::class, 'change_status'])->name('products-variant.change-status');
Route::resource('products-variant', ProductVariantController::class);

// Product Variant Item route
Route::get('products-variant-item/{product_id}/{variant_id}', [ProductVariantItemController::class, 'index'])->name('products-variant-item.index');
Route::get('products-variant-item/create/{product_id}/{variant_id}', [ProductVariantItemController::class, 'create'])->name('products-variant-item.create');
Route::post('products-variant-item', [ProductVariantItemController::class, 'store'])->name('products-variant-item.store');
Route::get('products-variant-item-edit/{variant_item_id}', [ProductVariantItemController::class, 'edit'])->name('products-variant-item.edit');
Route::put('products-variant-item-update/{variant_item_id}', [ProductVariantItemController::class, 'update'])->name('products-variant-item.update');
Route::delete('products-variant-item-delete/{variant_item_id}', [ProductVariantItemController::class, 'destroy'])->name('products-variant-item.destroy');
Route::put('products-variant-item-status', [ProductVariantItemController::class, 'change_status'])->name('products-variant-item.change_status');

// Seller Product route
Route::get('seller-products', [SellerProductController::class, 'index'])->name('seller-products.index');
Route::get('seller-pending-products', [SellerProductController::class, 'pending_products'])->name('seller-pending-products.index');
Route::put('change-approve-status', [SellerProductController::class, 'change_approve_status'])->name('change-approve-status');

// Flash sale routes
Route::get('flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale.index');
Route::put('flash-sale', [FlashSaleController::class, 'update'])->name('flash-sale.update');
Route::post('flash-sale/add-product', [FlashSaleController::class, 'add_product'])->name('flash-sale.add-product');
Route::put('flash-sale/show-at-home/change-status', [FlashSaleController::class, 'change_show_at_home_status'])->name('flash-sale.show-at-home.change-status');
Route::put('flash-sale-item-status', [FlashSaleController::class, 'change_status'])->name('flash-sale-item-status');
Route::delete('flash-sale-item/{id}', [FlashSaleController::class, 'destroy'])->name('flash-sale-item.destroy');
