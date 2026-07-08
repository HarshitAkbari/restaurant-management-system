<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\FoodType;
use App\Enums\TableStatus;
use App\Models\Area;
use App\Models\ExpenseCategory;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\RestaurantTable;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::query()->firstOrCreate(
            ['email' => 'owner@restaurant.test'],
            [
                'name' => 'Restaurant Owner',
                'password' => 'password',
                'phone' => '+91 9000000001',
                'is_active' => true,
            ],
        );

        if (! $owner->hasRole('owner')) {
            $owner->assignRole('owner');
        }

        $categories = [
            [
                'slug' => 'starters',
                'name' => 'Starters',
                'description' => 'Appetizers and small plates',
                'sort_order' => 1,
                'items' => [
                    ['name' => 'Paneer Tikka', 'sku' => 'ST-001', 'description' => 'Grilled cottage cheese with spices', 'price' => 220.00, 'food_type' => FoodType::Veg->value],
                    ['name' => 'Chicken Wings', 'sku' => 'ST-002', 'description' => 'Crispy fried chicken wings', 'price' => 280.00, 'food_type' => FoodType::NonVeg->value],
                    ['name' => 'French Fries', 'sku' => 'ST-003', 'description' => 'Classic salted fries', 'price' => 120.00, 'food_type' => FoodType::Veg->value],
                    ['name' => 'Masala Omelette', 'sku' => 'ST-004', 'description' => 'Spiced egg omelette', 'price' => 150.00, 'food_type' => FoodType::Egg->value],
                ],
            ],
            [
                'slug' => 'main-course',
                'name' => 'Main Course',
                'description' => 'Hearty mains',
                'sort_order' => 2,
                'items' => [
                    ['name' => 'Butter Chicken', 'sku' => 'MC-001', 'description' => 'Creamy tomato curry', 'price' => 320.00, 'food_type' => FoodType::NonVeg->value],
                    ['name' => 'Dal Makhani', 'sku' => 'MC-002', 'description' => 'Slow-cooked black lentils', 'price' => 240.00, 'food_type' => FoodType::Veg->value],
                    ['name' => 'Veg Biryani', 'sku' => 'MC-003', 'description' => 'Fragrant rice with vegetables', 'price' => 260.00, 'food_type' => FoodType::Veg->value],
                    ['name' => 'Egg Fried Rice', 'sku' => 'MC-004', 'description' => 'Wok-tossed rice with egg', 'price' => 220.00, 'food_type' => FoodType::Egg->value],
                ],
            ],
            [
                'slug' => 'beverages',
                'name' => 'Beverages',
                'description' => 'Drinks and refreshments',
                'sort_order' => 3,
                'items' => [
                    ['name' => 'Masala Chai', 'sku' => 'BV-001', 'description' => 'Spiced Indian tea', 'price' => 40.00, 'food_type' => FoodType::Veg->value],
                    ['name' => 'Fresh Lime Soda', 'sku' => 'BV-002', 'description' => 'Sweet or salted', 'price' => 60.00, 'food_type' => FoodType::Veg->value],
                    ['name' => 'Mango Lassi', 'sku' => 'BV-003', 'description' => 'Yogurt mango drink', 'price' => 90.00, 'food_type' => FoodType::Veg->value],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $items = $categoryData['items'];
            unset($categoryData['items']);

            $category = MenuCategory::query()->firstOrCreate(
                ['slug' => $categoryData['slug']],
                array_merge($categoryData, ['is_active' => true]),
            );

            foreach ($items as $index => $itemData) {
                MenuItem::query()->firstOrCreate(
                    ['sku' => $itemData['sku']],
                    array_merge($itemData, [
                        'menu_category_id' => $category->id,
                        'is_available' => true,
                        'is_active' => true,
                        'kitchen_station' => 'grill',
                        'prep_time_minutes' => 15,
                        'sort_order' => $index + 1,
                    ]),
                );
            }
        }

        $area = Area::query()->firstOrCreate(
            ['name' => 'Main Hall'],
            [
                'sort_order' => 1,
                'is_active' => true,
            ],
        );

        $tables = [
            ['name' => 'Table 1', 'code' => 'T1', 'capacity' => 2],
            ['name' => 'Table 2', 'code' => 'T2', 'capacity' => 4],
            ['name' => 'Table 3', 'code' => 'T3', 'capacity' => 6],
        ];

        foreach ($tables as $index => $tableData) {
            RestaurantTable::query()->firstOrCreate(
                [
                    'area_id' => $area->id,
                    'code' => $tableData['code'],
                ],
                array_merge($tableData, [
                    'capacity' => $tableData['capacity'],
                    'status' => TableStatus::Free,
                    'pos_x' => ($index + 1) * 100,
                    'pos_y' => 100,
                    'is_active' => true,
                ]),
            );
        }

        $expenseCategories = [
            'Rent',
            'Utilities',
            'Supplies',
            'Maintenance',
        ];

        foreach ($expenseCategories as $name) {
            ExpenseCategory::query()->firstOrCreate(
                ['name' => $name],
                ['is_active' => true],
            );
        }
    }
}
