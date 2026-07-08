<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\LoyaltySetting;
use App\Models\RestaurantSetting;
use Illuminate\Database\Seeder;

class RestaurantSettingSeeder extends Seeder
{
    public function run(): void
    {
        RestaurantSetting::query()->firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Demo Restaurant',
                'legal_name' => 'Demo Restaurant Pvt Ltd',
                'phone' => '+91 9876543210',
                'email' => 'info@demo-restaurant.test',
                'address' => '123 Main Street, Mumbai, Maharashtra 400001',
                'gstin' => '27AAAAA0000A1Z5',
                'currency' => 'INR',
                'timezone' => 'Asia/Kolkata',
                'cgst_percent' => 2.50,
                'sgst_percent' => 2.50,
                'service_charge_percent' => 0,
                'payment_methods' => ['cash', 'card', 'upi'],
                'printers' => [
                    ['name' => 'Receipt Printer', 'type' => 'receipt', 'is_enabled' => true],
                    ['name' => 'KOT Printer', 'type' => 'kot', 'is_enabled' => true],
                ],
            ],
        );

        LoyaltySetting::query()->firstOrCreate(
            ['id' => 1],
            [
                'is_enabled' => false,
                'points_per_rupee' => 1,
                'rupee_per_point' => 0.25,
                'min_redeem_points' => 100,
            ],
        );
    }
}
