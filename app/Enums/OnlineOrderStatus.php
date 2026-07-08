<?php

declare(strict_types=1);

namespace App\Enums;

enum OnlineOrderStatus: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Preparing = 'preparing';
    case Ready = 'ready';
    case Dispatched = 'dispatched';
    case Delivered = 'delivered';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Accepted => 'Accepted',
            self::Preparing => 'Preparing',
            self::Ready => 'Ready',
            self::Dispatched => 'Dispatched',
            self::Delivered => 'Delivered',
            self::Rejected => 'Rejected',
            self::Cancelled => 'Cancelled',
        };
    }
}
