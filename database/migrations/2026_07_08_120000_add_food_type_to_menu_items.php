<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('food_type', 10)->default('veg')->after('price');
        });

        DB::statement("UPDATE menu_items SET food_type = CASE WHEN is_veg = 1 THEN 'veg' ELSE 'non_veg' END");

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('is_veg');
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->boolean('is_veg')->default(true)->after('price');
        });

        DB::statement("UPDATE menu_items SET is_veg = CASE WHEN food_type = 'veg' THEN 1 ELSE 0 END");

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('food_type');
        });
    }
};
