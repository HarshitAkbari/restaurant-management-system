<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DayClose extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'business_date',
        'opening_cash',
        'closing_cash',
        'expected_cash',
        'cash_variance',
        'total_sales',
        'total_orders',
        'payment_breakdown',
        'notes',
        'closed_by',
        'closed_at',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'business_date' => 'date',
        'opening_cash' => 'decimal:2',
        'closing_cash' => 'decimal:2',
        'expected_cash' => 'decimal:2',
        'cash_variance' => 'decimal:2',
        'total_sales' => 'decimal:2',
        'total_orders' => 'integer',
        'payment_breakdown' => 'array',
        'closed_at' => 'datetime',
    ];

    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by');
    }
}
