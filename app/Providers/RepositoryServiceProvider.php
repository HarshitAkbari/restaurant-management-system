<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\AreaRepositoryInterface;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\DayCloseRepositoryInterface;
use App\Repositories\Contracts\ExpenseCategoryRepositoryInterface;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use App\Repositories\Contracts\KotRepositoryInterface;
use App\Repositories\Contracts\LoyaltySettingRepositoryInterface;
use App\Repositories\Contracts\MenuAddonRepositoryInterface;
use App\Repositories\Contracts\MenuCategoryRepositoryInterface;
use App\Repositories\Contracts\MenuComboRepositoryInterface;
use App\Repositories\Contracts\MenuItemRepositoryInterface;
use App\Repositories\Contracts\MenuVariantRepositoryInterface;
use App\Repositories\Contracts\OnlineOrderRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\OutletRepositoryInterface;
use App\Repositories\Contracts\PurchaseOrderRepositoryInterface;
use App\Repositories\Contracts\RawMaterialRepositoryInterface;
use App\Repositories\Contracts\RecipeRepositoryInterface;
use App\Repositories\Contracts\RestaurantSettingRepositoryInterface;
use App\Repositories\Contracts\RestaurantTableRepositoryInterface;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\AreaRepository;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\DayCloseRepository;
use App\Repositories\Eloquent\ExpenseCategoryRepository;
use App\Repositories\Eloquent\ExpenseRepository;
use App\Repositories\Eloquent\KotRepository;
use App\Repositories\Eloquent\LoyaltySettingRepository;
use App\Repositories\Eloquent\MenuAddonRepository;
use App\Repositories\Eloquent\MenuCategoryRepository;
use App\Repositories\Eloquent\MenuComboRepository;
use App\Repositories\Eloquent\MenuItemRepository;
use App\Repositories\Eloquent\MenuVariantRepository;
use App\Repositories\Eloquent\OnlineOrderRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\OutletRepository;
use App\Repositories\Eloquent\PurchaseOrderRepository;
use App\Repositories\Eloquent\RawMaterialRepository;
use App\Repositories\Eloquent\RecipeRepository;
use App\Repositories\Eloquent\RestaurantSettingRepository;
use App\Repositories\Eloquent\RestaurantTableRepository;
use App\Repositories\Eloquent\SupplierRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /** @var array<class-string, class-string> */
    public array $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
        MenuCategoryRepositoryInterface::class => MenuCategoryRepository::class,
        MenuItemRepositoryInterface::class => MenuItemRepository::class,
        MenuVariantRepositoryInterface::class => MenuVariantRepository::class,
        MenuAddonRepositoryInterface::class => MenuAddonRepository::class,
        MenuComboRepositoryInterface::class => MenuComboRepository::class,
        AreaRepositoryInterface::class => AreaRepository::class,
        RestaurantTableRepositoryInterface::class => RestaurantTableRepository::class,
        OrderRepositoryInterface::class => OrderRepository::class,
        KotRepositoryInterface::class => KotRepository::class,
        RestaurantSettingRepositoryInterface::class => RestaurantSettingRepository::class,
        CustomerRepositoryInterface::class => CustomerRepository::class,
        LoyaltySettingRepositoryInterface::class => LoyaltySettingRepository::class,
        SupplierRepositoryInterface::class => SupplierRepository::class,
        RawMaterialRepositoryInterface::class => RawMaterialRepository::class,
        RecipeRepositoryInterface::class => RecipeRepository::class,
        PurchaseOrderRepositoryInterface::class => PurchaseOrderRepository::class,
        ExpenseCategoryRepositoryInterface::class => ExpenseCategoryRepository::class,
        ExpenseRepositoryInterface::class => ExpenseRepository::class,
        DayCloseRepositoryInterface::class => DayCloseRepository::class,
        OutletRepositoryInterface::class => OutletRepository::class,
        OnlineOrderRepositoryInterface::class => OnlineOrderRepository::class,
    ];

    public function register(): void
    {
        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
