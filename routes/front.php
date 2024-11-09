<?php
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use Illuminate\Support\Facades\Route;

// home page
Route::get('/', [HomeController::class , 'index'])->name('home');

// show product details 
Route::get('/products' , [ProductsController::class , 'index'])->name('products.index');
Route::get('/products/{product:slug}' , [ProductsController::class , 'show'])->name('products.show');






?>
