<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\Inventory\AlertController;
use App\Http\Controllers\Admin\Inventory\MaterialController;
use App\Http\Controllers\Admin\Inventory\PurchaseOrderController;
use App\Http\Controllers\Admin\Inventory\RecipeController;
use App\Http\Controllers\Admin\Inventory\SupplierController;
use App\Http\Controllers\Admin\LoyaltyController;
use App\Http\Controllers\Admin\Menu\AddonController;
use App\Http\Controllers\Admin\Menu\CategoryController;
use App\Http\Controllers\Admin\Menu\ComboController;
use App\Http\Controllers\Admin\Menu\ItemController;
use App\Http\Controllers\Admin\Menu\VariantController;
use App\Http\Controllers\Admin\OnlineOrderController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\Settings\OutletController;
use App\Http\Controllers\Admin\Settings\SettingsController;
use App\Http\Controllers\Admin\Staff\RoleController;
use App\Http\Controllers\Admin\Staff\StaffController;
use App\Http\Controllers\Admin\Table\AreaController;
use App\Http\Controllers\Admin\Table\TableController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes — prefix /admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Orders
    Route::prefix('orders')->name('admin.orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/history', [OrderController::class, 'history'])->name('history');
        Route::get('/void-log', [OrderController::class, 'voidLog'])->name('void-log');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/{order}/void', [OrderController::class, 'void'])->name('void');
    });

    // Menu
    Route::prefix('menu')->name('admin.menu.')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('items', ItemController::class)->except(['show']);
        Route::patch('items/{item}/toggle-availability', [ItemController::class, 'toggleAvailability'])
            ->name('items.toggle-availability');
        Route::resource('variants', VariantController::class)->except(['show']);
        Route::resource('addons', AddonController::class)->except(['show']);
        Route::resource('combos', ComboController::class)->except(['show']);
    });

    // Tables & Areas
    Route::prefix('tables')->name('admin.tables.')->group(function () {
        Route::get('/layout', [TableController::class, 'layout'])->name('layout');
        Route::resource('areas', AreaController::class)->except(['show']);
        Route::get('/', [TableController::class, 'index'])->name('index');
        Route::get('/create', [TableController::class, 'create'])->name('create');
        Route::post('/', [TableController::class, 'store'])->name('store');
        Route::get('/{table}/edit', [TableController::class, 'edit'])->name('edit');
        Route::put('/{table}', [TableController::class, 'update'])->name('update');
        Route::delete('/{table}', [TableController::class, 'destroy'])->name('destroy');
    });

    // Inventory
    Route::prefix('inventory')->name('admin.inventory.')->group(function () {
        Route::resource('materials', MaterialController::class)->except(['show']);
        Route::resource('recipes', RecipeController::class)->except(['show']);
        Route::get('purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase-orders.index');
        Route::get('purchase-orders/create', [PurchaseOrderController::class, 'create'])->name('purchase-orders.create');
        Route::post('purchase-orders', [PurchaseOrderController::class, 'store'])->name('purchase-orders.store');
        Route::get('purchase-orders/{purchaseOrder}', [PurchaseOrderController::class, 'show'])->name('purchase-orders.show');
        Route::post('purchase-orders/{purchaseOrder}/receive', [PurchaseOrderController::class, 'receive'])
            ->name('purchase-orders.receive');
        Route::resource('suppliers', SupplierController::class)->except(['show']);
        Route::get('alerts', [AlertController::class, 'index'])->name('alerts');
    });

    // Staff
    Route::prefix('staff')->name('admin.staff.')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/', [StaffController::class, 'index'])->name('index');
        Route::get('/create', [StaffController::class, 'create'])->name('create');
        Route::post('/', [StaffController::class, 'store'])->name('store');
        Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('edit');
        Route::put('/{staff}', [StaffController::class, 'update'])->name('update');
        Route::post('/{staff}/deactivate', [StaffController::class, 'deactivate'])->name('deactivate');
    });

    // Customers & Loyalty
    Route::get('customers/loyalty', [LoyaltyController::class, 'index'])->name('admin.customers.loyalty');
    Route::put('customers/loyalty', [LoyaltyController::class, 'update'])->name('admin.customers.loyalty.update');
    Route::resource('customers', CustomerController::class)->except(['show'])->names([
        'index' => 'admin.customers.index',
        'create' => 'admin.customers.create',
        'store' => 'admin.customers.store',
        'edit' => 'admin.customers.edit',
        'update' => 'admin.customers.update',
        'destroy' => 'admin.customers.destroy',
    ]);
    Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('admin.customers.show');

    // Reports
    Route::prefix('reports')->name('admin.reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/items', [ReportController::class, 'items'])->name('items');
        Route::get('/tax', [ReportController::class, 'tax'])->name('tax');
        Route::get('/staff', [ReportController::class, 'staff'])->name('staff');
        Route::get('/inventory', [ReportController::class, 'inventory'])->name('inventory');
    });

    // Expenses
    Route::prefix('expenses')->name('admin.expenses.')->group(function () {
        Route::resource('categories', ExpenseCategoryController::class)->except(['show']);
        Route::get('/', [ExpenseController::class, 'index'])->name('index');
        Route::get('/create', [ExpenseController::class, 'create'])->name('create');
        Route::post('/', [ExpenseController::class, 'store'])->name('store');
        Route::get('/{expense}/edit', [ExpenseController::class, 'edit'])->name('edit');
        Route::put('/{expense}', [ExpenseController::class, 'update'])->name('update');
        Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->name('destroy');
    });

    // Online Orders
    Route::prefix('online-orders')->name('admin.online-orders.')->group(function () {
        Route::get('/', [OnlineOrderController::class, 'index'])->name('index');
        Route::get('/{onlineOrder}', [OnlineOrderController::class, 'show'])->name('show');
        Route::post('/{onlineOrder}/accept', [OnlineOrderController::class, 'accept'])->name('accept');
        Route::post('/{onlineOrder}/reject', [OnlineOrderController::class, 'reject'])->name('reject');
        Route::patch('/{onlineOrder}/status', [OnlineOrderController::class, 'updateStatus'])->name('status');
    });

    // Settings
    Route::prefix('settings')->name('admin.settings.')->group(function () {
        Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');
        Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('profile.update');
        Route::get('/tax', [SettingsController::class, 'tax'])->name('tax');
        Route::put('/tax', [SettingsController::class, 'updateTax'])->name('tax.update');
        Route::get('/payments', [SettingsController::class, 'payments'])->name('payments');
        Route::put('/payments', [SettingsController::class, 'updatePayments'])->name('payments.update');
        Route::get('/printers', [SettingsController::class, 'printers'])->name('printers');
        Route::put('/printers', [SettingsController::class, 'updatePrinters'])->name('printers.update');
        Route::resource('outlets', OutletController::class)->except(['show']);
    });
});
