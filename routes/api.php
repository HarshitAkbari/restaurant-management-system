<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\KotController;
use App\Http\Controllers\Api\V1\MenuController;
use App\Http\Controllers\Api\V1\OnlineOrderController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\TableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Public online menu stub
    Route::get('/online/menu', [OnlineOrderController::class, 'menu']);
    Route::post('/online/orders', [OnlineOrderController::class, 'store']);

    Route::middleware(['auth:sanctum', 'active'])->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);

        Route::get('/menu/categories', [MenuController::class, 'categories']);
        Route::get('/menu/items', [MenuController::class, 'items']);

        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);

        Route::get('/tables', [TableController::class, 'index']);

        Route::get('/kot', [KotController::class, 'index']);
        Route::patch('/kot/{kot}', [KotController::class, 'updateStatus']);

        Route::get('/online/orders', [OnlineOrderController::class, 'index']);
    });
});
