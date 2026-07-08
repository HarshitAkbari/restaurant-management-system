<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OnlineOrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnlineOrder extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'external_id',
        'channel',
        'customer_name',
        'customer_phone',
        'status',
        'total_amount',
        'items',
        'notes',
        'order_id',
        'accepted_at',
        'rejected_at',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'status' => OnlineOrderStatus::class,
        'total_amount' => 'decimal:2',
        'items' => 'array',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
