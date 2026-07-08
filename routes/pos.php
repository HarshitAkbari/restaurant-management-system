<?php

declare(strict_types=1);

use App\Http\Controllers\Pos\DashboardController;
use App\Http\Controllers\Pos\DayCloseController;
use App\Http\Controllers\Pos\HoldController;
use App\Http\Controllers\Pos\KitchenController;
use App\Http\Controllers\Pos\OrderController;
use App\Http\Controllers\Pos\TableController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| POS Routes — prefix /pos
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('pos.dashboard');

    Route::get('/tables', [TableController::class, 'index'])->name('pos.tables.index');
    Route::get('/tables/{table}/open', [TableController::class, 'open'])->name('pos.tables.open');
    Route::post('/quick-order/{type}', [TableController::class, 'quickOrder'])->name('pos.quick-order');

    Route::prefix('orders')->name('pos.orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/{order}/items', [OrderController::class, 'addItem'])->name('items.store');
        Route::put('/{order}/items/{item}', [OrderController::class, 'updateItem'])->name('items.update');
        Route::delete('/{order}/items/{item}', [OrderController::class, 'removeItem'])->name('items.destroy');
        Route::post('/{order}/send-kot', [OrderController::class, 'sendKot'])->name('send-kot');
        Route::post('/{order}/kot-print', [OrderController::class, 'kotAndPrint'])->name('kot-print');
        Route::post('/{order}/save', [OrderController::class, 'save'])->name('save');
        Route::post('/{order}/save-print', [OrderController::class, 'saveAndPrint'])->name('save-print');
        Route::post('/{order}/save-ebill', [OrderController::class, 'saveAndEbill'])->name('save-ebill');
        Route::get('/{order}/print/bill', [OrderController::class, 'printBill'])->name('print.bill');
        Route::get('/{order}/print/kot', [OrderController::class, 'printKot'])->name('print.kot');
        Route::post('/{order}/hold', [OrderController::class, 'hold'])->name('hold');
        Route::post('/{order}/resume', [OrderController::class, 'resume'])->name('resume');
        Route::post('/{order}/payments', [OrderController::class, 'pay'])->name('pay');
        Route::post('/{order}/void', [OrderController::class, 'void'])->name('void');
    });

    Route::get('/kitchen', [KitchenController::class, 'index'])->name('pos.kitchen.index');
    Route::patch('/kitchen/kots/{kot}', [KitchenController::class, 'updateStatus'])->name('pos.kitchen.update-status');

    Route::get('/hold', [HoldController::class, 'index'])->name('pos.hold.index');

    Route::get('/day-close', [DayCloseController::class, 'index'])->name('pos.day-close.index');
    Route::post('/day-close', [DayCloseController::class, 'store'])->name('pos.day-close.store');
});
