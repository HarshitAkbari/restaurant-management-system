<?php

declare(strict_types=1);

namespace App\Enums;

enum TableStatus: string
{
    case Free = 'free';
    case Occupied = 'occupied';
    case Billed = 'billed';
    case Reserved = 'reserved';

    public function label(): string
    {
        return match ($this) {
            self::Free => 'Free',
            self::Occupied => 'Occupied',
            self::Billed => 'Billed',
            self::Reserved => 'Reserved',
        };
    }
}
