<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Models\Category;

// Landing page
Route::get('/', function () {
    return view('welcome', [
        'saleCategories' => Category::ofType(Category::TYPE_SALE)->get(),
        'rentCategories' => Category::ofType(Category::TYPE_RENT)->get(),
    ]);
})->name('home');

// Shop (items for sale)
Route::get('/shop', [CatalogController::class, 'shop'])->name('shop');
Route::get('/shop/{category}', [CatalogController::class, 'shopCategory'])->name('shop.category');

// Rentals (items for hire)
Route::get('/rentals', [CatalogController::class, 'rentals'])->name('rentals');
Route::get('/rentals/{category}', [CatalogController::class, 'rentalCategory'])->name('rentals.category');

// Information pages
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// Login routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin area (shop owner only)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/products')->name('dashboard');

    Route::resource('products', ProductController::class)->except('show');
    Route::patch('products/{product}/availability', [ProductController::class, 'toggleAvailability'])
        ->name('products.availability');

    Route::resource('categories', CategoryController::class)->except('show');
});
