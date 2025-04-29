<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ProductController;
Route::prefix('v1')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/count', [ProductController::class, 'count']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::get('/name/{name}', [ProductController::class, 'findByName']);
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });
});