<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderType: string
{
    case DineIn = 'dine_in';
    case Takeaway = 'takeaway';
    case Delivery = 'delivery';
    case Online = 'online';

    public function label(): string
    {
        return match ($this) {
            self::DineIn => 'Dine In',
            self::Takeaway => 'Takeaway',
            self::Delivery => 'Delivery',
            self::Online => 'Online',
        };
    }
}
