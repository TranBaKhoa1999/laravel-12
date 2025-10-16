<?php

use App\Http\Controllers\Api\v1\AssistantController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\ProductsController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


// public routes
// Route::get('/products/{slug_category?}', [ProductsController::class, 'index']);
// Route::get('/products/{slug_category}/{slug_product}', [ProductsController::class, 'show']);

// Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);




// Logged routes
Route::middleware(['auth:sanctum'])->group(function () {

    // admin routes
    Route::middleware(['role:' . User::ADMIN_ROLE])->group(function () {
        // need to except index/show routes to avoid require login
        // Route::apiResource('products', ProductsController::class)->except(['index', 'show']);
    });

    // user routes
    Route::middleware(['role:' . User::USER_ROLE])->group(function () {
        // doesn't need to add products routes here, because they are already added in public routes
    });

});