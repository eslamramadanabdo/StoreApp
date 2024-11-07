<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;




Route::group([
    'middleware' => 'auth',
    'as'         => 'dashboard.',
    'prefix'     => 'dashboard'
] , function (){
    // dashboard
    Route::get('/', [DashboardController::class , 'index'])
            ->name('dashboard');

    Route::get('profile/show' ,[ProfileController::class , 'index'] )->name('profile.index');
    Route::get('profile' ,[ProfileController::class , 'edit'] )->name('profile.edit');
    Route::patch('profile' ,[ProfileController::class , 'update'] )->name('profile.update');


    Route::get('categories/trash' , [CategoriesController::class , 'trash'])->name('categories.trash');
    Route::put('categories/{category}/restore' , [CategoriesController::class , 'restore'])->name('categories.restore');
    Route::delete('categories/{category}/force-delete' , [CategoriesController::class , 'forceDelete'])->name('categories.force-delete');

    // categories
    Route::resource('/categories' , CategoriesController::class);


    Route::get('products/trash' , [ProductsController::class , 'trash'])->name('products.trash');
    Route::put('products/{product}/restore' , [ProductsController::class , 'restore'])->name('products.restore');
    Route::delete('products/{product}/force-delete' , [ProductsController::class , 'forceDelete'])->name('products.force-delete');

    // products
    Route::resource('/products' , ProductsController::class);

});



