<?php

use App\Http\Controllers\HomeController;
use App\Livewire\ProductList;
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
