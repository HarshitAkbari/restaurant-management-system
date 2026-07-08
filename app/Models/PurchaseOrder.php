<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'po_number',
        'supplier_id',
        'status',
        'total_amount',
        'ordered_at',
        'received_at',
        'notes',
        'created_by',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'ordered_at' => 'date',
        'received_at' => 'date',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
