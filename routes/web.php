<?php

use App\Livewire\ProductList;
use App\Livewire\ProductDetail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', ProductList::class)->name('home');
Route::get('/product/{product:slug}', ProductDetail::class)->name('product.detail');
