<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Public routes (no auth middleware)
Route::get('/', [AdminController::class, 'login'])->name('login');
Route::post('/login-check', [AdminController::class, 'logincheck'])->name('logincheck');

// Protected routes (require admin auth)
Route::group(['middleware'=> ['auth:admin'], 'prefix' => 'admin'], function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/logout', [AdminController::class, 'logout'])->name('logout');

    //CATEGORY ROUTES
    Route::get('/categories', [AdminController::class, 'category'])->name('admin.categories.index');
    Route::get('/test-category-create', [AdminController::class, 'categorycreate'])->name('admin.categories.create');
    Route::post('/categories', [AdminController::class, 'categorystore'])->name('admin.categories.store');
    Route::get('/categories/search', [AdminController::class, 'searchParentCategories'])->name('admin.categories.search');
    Route::delete('/categories/{category}', [AdminController::class, 'destroy'])->name('admin.categories.destroy');
    Route::get('/categories/{category}/edit', [AdminController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [AdminController::class, 'update'])->name('admin.categories.update');

    //BUSINESS ROUTES
    Route::get('/bunsiness/add', [AdminController::class,'bunsinesadd'])->name('bunsiness.add');
    Route::post('/bunsiness/store', [AdminController::class,'bunsinesstore'])->name('admin.businesses.store');
    Route::get('/businesses', [AdminController::class,'businesses'])->name('admin.businesses.index');
    Route::get('/get-states/{country_id}', [AdminController::class, 'getStates']);
    Route::get('/get-cities/{state_id}', [AdminController::class, 'getCities']);
});

