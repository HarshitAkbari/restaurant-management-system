<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderStatus: string
{
    case Draft = 'draft';
    case Open = 'open';
    case Held = 'held';
    case Billed = 'billed';
    case Paid = 'paid';
    case Voided = 'voided';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Open => 'Open',
            self::Held => 'Held',
            self::Billed => 'Billed',
            self::Paid => 'Paid',
            self::Voided => 'Voided',
            self::Cancelled => 'Cancelled',
        };
    }

    public function isActive(): bool
    {
        return in_array($this, [self::Draft, self::Open, self::Held, self::Billed], true);
    }
}
