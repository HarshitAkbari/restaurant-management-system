<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemRemoval extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'order_id',
        'order_item_id',
        'item_name',
        'quantity',
        'unit_price',
        'line_total',
        'reason',
        'removed_by',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function removedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'removed_by');
    }
}
