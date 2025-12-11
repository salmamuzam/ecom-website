<?php

use App\Http\Controllers\HomeController;
use App\Livewire\CategoryForm;
use App\Livewire\CategoryList;
use App\Livewire\ProductList;
use App\Livewire\ProductForm;
//use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route::get('/panel', [AdminController::class, 'index'])->name('panel');

Route::get('products', ProductList::class)->name('products');
Route::get('products/create', ProductForm::class)->name('products.create');
Route::get('products/{product}/view', ProductForm::class)->name('products.view');
Route::get('products/{product}/edit', ProductForm::class)->name('products.edit');

Route::get('categories', CategoryList::class)->name('categories');
Route::get('categories/create', CategoryForm::class)->name('categories.create');
Route::get('categories/{category}/view', CategoryForm::class)->name('categories.view');
Route::get('categories/{category}/edit', CategoryForm::class)->name('categories.edit');
