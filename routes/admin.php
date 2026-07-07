<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Restaurant back-office modules will be registered here.
| Prefix: /admin (set in RouteServiceProvider)
|
| Planned modules:
| - Dashboard
| - Menu & categories
| - Inventory
| - Staff & roles
| - Customers
| - Reports
| - Restaurant settings
|
*/

Route::get('/', function () {
    return response('Admin module — coming soon.', 200);
})->name('admin.dashboard');
