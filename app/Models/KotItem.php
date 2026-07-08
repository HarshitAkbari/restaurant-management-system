<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KotItem extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'kot_id',
        'order_item_id',
        'name',
        'quantity',
        'notes',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'quantity' => 'integer',
    ];

    public function kot(): BelongsTo
    {
        return $this->belongsTo(Kot::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}
