<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes (no auth middleware)
Route::get('/', [AdminController::class, 'login'])->name('login');
Route::post('/login-check', [AdminController::class, 'logincheck'])->name('logincheck');
// Route::get('/admin/test-category-create', [AdminController::class, 'categorycreate'])->name('categories.create');

Route::get('/admin/test-category-create', function () {
        return view('layouts.pages.categorycreate');
    })->name('categories.create');
// Protected routes (require admin auth)
Route::group(['middleware'=> ['auth:admin'], 'prefix' => 'admin'], function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/logout', [AdminController::class, 'logout'])->name('logout');

    // Category routes
    Route::get('/categories', [AdminController::class, 'category'])->name('categories.index');



    Route::post('/categories', [AdminController::class, 'categorystore'])->name('categories.store');
    Route::get('/categories/search', [AdminController::class, 'searchParentCategories'])->name('categories.search');
});


