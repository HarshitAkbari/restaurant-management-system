<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| POS Routes
|--------------------------------------------------------------------------
|
| Point-of-sale and in-restaurant operations will be registered here.
| Prefix: /pos (set in RouteServiceProvider)
|
| Planned modules:
| - Billing / checkout
| - Table management
| - KOT / kitchen display
| - Order status
|
*/

Route::get('/', function () {
    return response('POS module — coming soon.', 200);
})->name('pos.dashboard');
