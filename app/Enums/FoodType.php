<?php

declare(strict_types=1);

namespace App\Enums;

enum FoodType: string
{
    case Veg = 'veg';
    case NonVeg = 'non_veg';
    case Egg = 'egg';

    public function label(): string
    {
        return match ($this) {
            self::Veg => 'Veg',
            self::NonVeg => 'Non-Veg',
            self::Egg => 'Eggetarian',
        };
    }

    public function isVeg(): bool
    {
        return $this === self::Veg;
    }
}
